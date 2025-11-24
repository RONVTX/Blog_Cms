<?php

class CookieController extends BaseController {
    public function show() {
        $consent = Cookie::get('cookie_consent');
        $this->view('cookies', ['consent' => $consent]);
    }

    public function update() {
        $choice = $_POST['cookie_consent'] ?? '';
        if ($choice === 'accepted') {
            Cookie::set('cookie_consent', 'accepted', 365);
            Session::flash('success', 'Has aceptado las cookies.');
        } elseif ($choice === 'declined') {
            Cookie::set('cookie_consent', 'declined', 365);
            Session::flash('success', 'Has rechazado las cookies.');
        }
        $this->redirect('/cookies');
    }
}
