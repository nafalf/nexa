<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;

Route::middleware('auth')->group(function () {
    Route::get('/accounts', fn (Request $request) => $request->user()->accounts()->paginate(10));
    Route::get('/beneficiaries', fn (Request $request) => $request->user()->beneficiaries()->paginate(10));
    Route::post('/beneficiaries', fn (Request $request) => response()->json($request->user()->beneficiaries()->create($request->validate(['name'=>'required','bank'=>'required','number'=>'required'])), 201));
    Route::put('/beneficiaries/{id}', function (Request $request, int $id) { $beneficiary=$request->user()->beneficiaries()->findOrFail($id); $beneficiary->update($request->validate(['name'=>'sometimes|required','bank'=>'sometimes|required','number'=>'sometimes|required'])); return $beneficiary; });
    Route::delete('/beneficiaries/{id}', function (Request $request, int $id) { $request->user()->beneficiaries()->findOrFail($id)->delete(); return response()->noContent(); });
    Route::get('/transactions', fn (Request $request) => $request->user()->transactions()->latest()->paginate(10));
    Route::get('/admin/statistics', fn () => ['users'=>\App\Models\User::count(),'transactions'=>Transaction::count(),'volume'=>Transaction::sum('amount')]);
});
