<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    protected array $ignored = [
        'updated_at',
        'created_at',
    ];

    public function created(Model $model): void
    {
        $this->log('created', $model);
    }

    public function updated(Model $model): void
    {
        $changes = array_diff_key(
            $model->getChanges(),
            array_flip($this->ignored)
        );

        if (empty($changes)) {
            return;
        }

        $this->log('updated', $model, [
            'changes' => $changes,
            'original' => $model->getOriginal(),
        ]);
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model);
    }

    protected function log(string $action, Model $model, array $details = []): void
    {
        AuditLog::create([
            'user_id'   => Auth::id(), // nullable allowed
            'action'    => $action,
            'model_type' => get_class($model),
            'model_id'  => $model->getKey(),
            'details'   => empty($details) ? null : json_encode($details),
        ]);
    }
}
