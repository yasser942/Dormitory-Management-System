<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $studentsWithUnpaidFees = User::where('role_id', 2) // Assuming role_id 2 is for students
    -> when($searchQuery, function ($query, $searchQuery) {
          return $query->where(function ($subQuery) use ($searchQuery) {
              $subQuery->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('email', 'like', '%' . $searchQuery . '%');
          });
      })
        ->with(['fees' => function ($query) {
            $query->wherePivot('paid', false);
        }])
            ->paginate(10);
        return view('payment.index', compact('studentsWithUnpaidFees'));
    }
    public function markFeesAsPaid($userId)
    {
        try {
            DB::beginTransaction();

            // Find the user
            $user = User::findOrFail($userId);


            // Get the unpaid fees and mark them as paid
            $unpaidFees = $user->fees()->wherePivot('paid', false)->get();
            foreach ($unpaidFees as $fee) {
                $user->fees()->updateExistingPivot($fee->id, ['paid' => true]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Fees marked as paid successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to mark fees as paid: ' . $e->getMessage());
        }
    }

}
