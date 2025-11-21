<?php

class FollowerController extends BaseController {
    private $followerModel;

    public function __construct() {
        $this->followerModel = new Follower();
    }

    public function toggle($userId) {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        if ($userId == Session::getUserId()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'No puedes seguirte a ti mismo']);
            exit;
        }

        $this->followerModel->toggle(Session::getUserId(), $userId);
        $isFollowing = $this->followerModel->isFollowing(Session::getUserId(), $userId);
        $followersCount = $this->followerModel->getFollowersCount($userId);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'is_following' => $isFollowing,
            'followers_count' => $followersCount
        ]);
        exit;
    }

    public function followers($username) {
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if (!$user) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            exit;
        }

        $followers = $this->followerModel->getFollowers($user['id']);
        
        $this->view('followers/index', [
            'user' => $user,
            'followers' => $followers,
            'type' => 'followers'
        ]);
    }

    public function following($username) {
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if (!$user) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            exit;
        }

        $following = $this->followerModel->getFollowing($user['id']);
        
        $this->view('followers/index', [
            'user' => $user,
            'followers' => $following,
            'type' => 'following'
        ]);
    }
}
