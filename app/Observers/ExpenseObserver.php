<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
    // This method will log when an Expense record is created
    public function created(Expense $expense)
    {
        $this->logChanges('created', $expense);
    }

    // This method will log when an Expense record is updated
    public function updated(Expense $expense)
    {
        $this->logChanges('updated', $expense);
    }

    // This method will log when an Expense record is deleted
    public function deleted(Expense $expense)
    {
        $this->logChanges('deleted', $expense);
    }

    // Helper function to log changes
    private function logChanges(string $action, Expense $expense)
    {
        $user = Auth::user();
        $changes = $expense->getChanges();
        $changedBy = $user ? $user->name : 'System';

        // Save to the audit_logs table
        AuditLog::create([
            'table_name' => 'expenses',
            'record_id' => $expense->id,
            'changes' => json_encode($changes), // store changes as a JSON string
            'changed_by' => $changedBy,
        ]);
    }
}
