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
            Balance::where('id', $request->id)
                ->update([
                    'total_amount' => $request->total_amount,
                    'current_balance' => $request->current_balance,
                ]);
            return new JsonResponse(['status' => Response::HTTP_OK], Response::HTTP_OK);
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
            Balance::where('id', $request->id)
                ->update([
                    'total_amount' => $request->total_amount,
                    'current_balance' => $request->current_balance,
                ]);
            return new JsonResponse(['status' => Response::HTTP_OK], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
    }
}
