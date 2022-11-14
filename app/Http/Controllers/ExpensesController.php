<?php

namespace App\Http\Controllers;

use App\Events\ExpenseCreated;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authorization = Gate::inspect('viewAny', User::class);

        $expenses = Expense::with('owner')
            ->latest();

        if ($authorization->denied()) {
            $expenses->byOwnerId($request->user()->id);
        }

        return ExpenseResource::collection($expenses->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        ExpenseCreated::dispatch($expense);

        return new ExpenseResource($expense);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        Gate::authorize('view', $expense);

        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateExpenseRequest  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return response()->json(['Expense updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        Gate::authorize('forceDelete', $expense);

        $expense->delete();

        return response()->json(['Expense deleted.']);
    }
}
