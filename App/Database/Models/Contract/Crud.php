<?php

namespace App\Database\Models\Contract;

interface Crud {
    function create();
    function read();
    function update();
    function delete();
}