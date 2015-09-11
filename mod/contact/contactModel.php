<?php


class contactModel extends Model {

    public function __construct($connection = DEFAULT_CONNECTION) {
        parent::__construct($connection);
    }

    public function saveContact($post) {

        $this->addInsertSet('name',  $post['nome']);
        $this->addInsertSet('email', $post['email']);
        $this->addInsertSet('phone', $post['phone']);
        $this->addInsertSet('message', $post['message']);

        $this->setInsertTable('contacts');
        $this->runInsert();

    }
}