<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface{

    public function getByDepartament($id);

    public function all($count);
}
