<?php

namespace App\Controllers;

use FWork\Cores\Controller;

class Contact extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $contacts = \App\Models\Contact::get_all($this->db);

        $cnt = array(
            'webtitle' => $this->configs['webtitle'],
            'baseurl' => $this->configs['baseurl'],
            'contacts' => $contacts
        );
        $this->render("contact", $cnt);
    }

    public function edit($id = "") {
        $contact = \App\Models\Contact::get_one($this->db, $id);

        $contacts = \App\Models\Contact::get_all($this->db);

        $cnt = array(
            'webtitle' => $this->configs['webtitle'],
            'baseurl' => $this->configs['baseurl'],
            'contact' => $contact,
            'contacts' => $contacts
        );
        $this->render("contact", $cnt);
    }

    public function submit() {
        $id = $this->request->params['contactId'];
        $name = $this->request->params['contactFname'];
        $email = $this->request->params['contactEmail'];
        $msg = $this->request->params['contactMsg'];

        if (!empty($id)) {
            $contact = \App\Models\Contact::get_one($this->db, $id);
            $contact->name = $name;
            $contact->email = $email;
            $contact->msg = $msg;
            $contact->save();
        } else {
            $data = array(
                'name' => $name,
                'email' => $email,
                'msg' => $msg
            );

            $contact = \App\Models\Contact::create($this->db, $data);
            $contact->save();
        }

        $this->redirect($this->configs['baseurl'] . "/contact");
    }

    public function delete($id = "") {
        if (!empty($id)) {
            $contact = \App\Models\Contact::get_one($this->db, $id);
            $contact->delete();
        }

        $this->redirect($this->configs['baseurl'] . "/contact");
    }

}