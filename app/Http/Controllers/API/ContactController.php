<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponse;

    private ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function getContact()
    {
        $data = $this->contactService->getContact();
        return $this->success("Get Contact successfully", new ContactResource($data));

    }
}
