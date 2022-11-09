<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BalanceController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {
            $balance = Balance::where('id', $request->id)->get();
            return new JsonResponse(['data' => $balance], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cash_in(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'total_amount' => 'required',
            'current_balance' => 'required',
        ]);

        try {
            $balance = Balance::where('id', $request->id);

            $total_remaining = $balance->total_amount + $request->cash_in;
            $total_balance = $balance->current_balance + $request->cash_in;

            $updated_balance = Balance::where('id', $request->id)
                ->update([
                    'total_amount' => $total_remaining,
                    'current_balance' => $total_balance,
                ]);
            return new JsonResponse(['data' => $updated_balance, 'status' => Response::HTTP_OK], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
    }

    public function debit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'total_amount' => 'required',
            'current_balance' => 'required',
        ]);

        try {
            $balance = Balance::where('id', $request->id);

            $total_remaining = $balance->used_amount + $request->debit_amount;
            $total_debit = $balance->total_amount + $request->debit_amount;
            $total_balance = $balance->current_balance - $request->debit_amount;

            Balance::where('id', $request->id)
                ->update([
                    'total_amount' => $total_debit,
                    'current_balance' => $total_balance,
                    'used_amount' => $total_remaining
                ]);
            return new JsonResponse(['status' => Response::HTTP_OK], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
    }
}
