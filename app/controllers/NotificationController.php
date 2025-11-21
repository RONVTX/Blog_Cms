<?php

class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new Notification();
    }

    public function index() {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        $notifications = $this->notificationModel->getByUser(Session::getUserId());
        $this->view('notifications/index', ['notifications' => $notifications]);
    }

    public function markAsRead($id) {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false]);
            exit;
        }

        $this->notificationModel->markAsRead($id, Session::getUserId());
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public function markAllAsRead() {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        $this->notificationModel->markAllAsRead(Session::getUserId());
        $this->redirect('/notifications');
    }

    public function getUnreadCount() {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['count' => 0]);
            exit;
        }

        $count = $this->notificationModel->getUnreadCount(Session::getUserId());
        
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
        exit;
    }
}