<?php
require_once ROOT . 'app/models/User.php';

class SuperAdminController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function checkSuperAdmin(): void
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
            header('Location: ?action=home');
            exit;
        }
    }

    public function index(): void
    {
        $this->checkSuperAdmin();

        $userModel   = new User($this->pdo);
        $recherche   = trim($_GET['q'] ?? '');
        $users       = $userModel->getAll($recherche);
        $users_stats = $userModel->getUsersActivity();
        $stats       = $userModel->getStats();
        $total       = array_sum($stats);

        $messages = [
            'role_updated'   => ['✅ Rôle mis à jour avec succès.',                        'green'],
            'user_deleted'   => ['✅ Utilisateur supprimé.',                               'green'],
            'user_added'     => ['✅ Utilisateur créé avec succès.',                       'green'],
            'cannot_self'    => ['⚠️ Vous ne pouvez pas modifier votre propre compte.',   'yellow'],
            'email_exists'   => ['⚠️ Cet email est déjà utilisé.',                        'yellow'],
            'missing_fields' => ['⚠️ Tous les champs obligatoires sont requis.',          'yellow'],
            'error'          => ['❌ Une erreur est survenue.',                            'red'],
        ];

        require_once ROOT . 'app/views/admin/super_admin.php';
    }

    public function action(): void
    {
        $this->checkSuperAdmin();

        $userModel = new User($this->pdo);
        $action    = $_POST['action'] ?? '';

        switch ($action) {
            case 'change_role':
                $idUser = (int)$_POST['id_user'];
                $role   = $_POST['role'] ?? 'user';
                if ($idUser === (int)$_SESSION['id_user']) {
                    header('Location: ?action=super_admin&msg=cannot_self');
                    exit;
                }
                $userModel->changeRole($idUser, $role);
                header('Location: ?action=super_admin&msg=role_updated');
                exit;

            case 'delete_user':
                $idUser = (int)$_POST['id_user'];
                if ($idUser === (int)$_SESSION['id_user']) {
                    header('Location: ?action=super_admin&msg=cannot_self');
                    exit;
                }
                $userModel->deleteUser($idUser);
                header('Location: ?action=super_admin&msg=user_deleted');
                exit;

            case 'add_user':
                $firstname = trim($_POST['firstname'] ?? '');
                $name      = trim($_POST['name'] ?? '');
                $email     = trim($_POST['email'] ?? '');
                $birthdate = $_POST['birthdate'] ?? '';
                $phone     = trim($_POST['phone'] ?? '');
                $role      = $_POST['role'] ?? 'user';
                $password  = $_POST['password'] ?? '';

                if (empty($firstname) || empty($name) || empty($email) || empty($password)) {
                    header('Location: ?action=super_admin&msg=missing_fields');
                    exit;
                }
                if ($userModel->emailExists($email)) {
                    header('Location: ?action=super_admin&msg=email_exists');
                    exit;
                }
                $userModel->addUser($firstname, $name, $email, $birthdate, $phone, $role, $password);
                header('Location: ?action=super_admin&msg=user_added');
                exit;

            default:
                header('Location: ?action=super_admin');
                exit;
        }
    }
    public function viewUser(): void
{
    $this->checkSuperAdmin();

    $idUser    = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($idUser <= 0) {
        header('Location: ?action=super_admin');
        exit;
    }

    $userModel = new User($this->pdo);
    $user      = $userModel->getById($idUser);

    if (!$user) {
        header('Location: ?action=super_admin');
        exit;
    }

    $orders   = $userModel->getOrder($idUser);
    $wishlist = $userModel->getWishlistItems($idUser);
    $avatar   = !empty($user['profile_picture'])
        ? 'public/uploads/avatars/' . $user['profile_picture']
        : 'public/images/default-avatar.png';

    require_once ROOT . 'app/views/admin/super_admin_view_user.php';
}
}