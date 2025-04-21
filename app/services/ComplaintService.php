<?php


namespace App\services;


use App\Models\Complaint;

class ComplaintService
{
    public function create($request)
    {
        $comp = Complaint::create($request);
        return $comp;
    }

    public function update($request, $complaint){

        $complaint->update($request);
        return $complaint;
    }

    public function delete($complaint){
        $complaint->delete();
    }

}
