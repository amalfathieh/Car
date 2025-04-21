<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Http\Responses\Response;
use App\Models\Complaint;
use App\services\ComplaintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\alert;
use function Symfony\Component\String\u;

class ComplaintController extends Controller
{

    protected $complaintService;
    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }

    //CREATE NEW COMPLAINT
    public function create(ComplaintRequest $request)
    {
        $complaint = $this->complaintService->create($request->all());

        return Response::Success($complaint,'complaint create successfully',201);
    }


    public function updateStatus(Request $request, $id){
        $request->validate([
           'status'=>'in:accepted,waiting,rejected'
        ]);
        $complaint= Complaint::find($id);
        if($complaint){
            $complaint = $this->complaintService->update($request->only('status'), $complaint);
            return Response::Success($complaint,'complaint updated successfully');
        }
        return Response::Error('not found',404);
    }

    public function delete($id){
        $complaint = Complaint::find($id);
        if ($complaint){
            $this->complaintService->delete($complaint);
            return Response::Success(null,'Complaint deleted successfully');
        }
        return Response::Error('not found',404);
    }

    //  RETRIEVE SPECIFIC COMPLAINT BY ID
    public function getComplaint($id){
        $complaint = Complaint::find($id);
        if (!$complaint){
            return Response::Error('Complaint not found', 404);
        }
        return Response::Success($complaint, 'Complaint');
    }

    //  RETRIEVE A LIST OF COMPLAINTS
    public function getComplaints(){
        $complaint = Complaint::all();
        return Response::Success($complaint, 'all Complaint');
    }

    //  RETRIEVE A LIST OF ACCEPTED COMPLAINTS
    public function getAcceptedComplaints(){
        $complaint = Complaint::where('status' , 'accepted');
        return Response::Success($complaint, 'accepted Complaints');
    }
}
