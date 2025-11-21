<?php

class ReportController extends BaseController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new Report();
    }

    public function store() {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Debes iniciar sesión');
            $this->redirect('/login');
        }

        $reportedType = $_POST['reported_type'] ?? '';
        $reportedId = $_POST['reported_id'] ?? 0;
        $reason = $_POST['reason'] ?? '';

        if (empty($reason)) {
            Session::flash('error', 'Debes proporcionar una razón');
            $this->back();
        }

        if ($this->reportModel->hasReported(Session::getUserId(), $reportedType, $reportedId)) {
            Session::flash('error', 'Ya has reportado este contenido');
            $this->back();
        }

        if ($this->reportModel->create(Session::getUserId(), $reportedType, $reportedId, $reason)) {
            Session::flash('success', 'Reporte enviado. Lo revisaremos pronto.');
        } else {
            Session::flash('error', 'Error al enviar el reporte');
        }

        $this->back();
    }
}