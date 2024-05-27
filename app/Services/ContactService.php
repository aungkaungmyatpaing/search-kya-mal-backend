<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    public function getContact()
    {
        $data = Contact::first();

        return $data;
    }
}
