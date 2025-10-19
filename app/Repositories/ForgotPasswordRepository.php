<?php

namespace App\Repositories;

use App\Repositories\Contracts\ForgotPasswordRepository as ForgotPasswordRepositoryContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use App\Models\User;

class ForgotPasswordRepository implements ForgotPasswordRepositoryContract
{
    /**
     * Attempt to reset password (new password).
     *
     * @param string $email
     * @param string $password
     * @return void
     * 
     * @throws \Illuminate\Database\QueryException database query fails exception.
     * @throws Exception general exception.
     */
    public function attemptResetPassword(string $email, string $password): void
    {
        try {
            $user = User::where('email', $email)->first();

            DB::transaction(function () use ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => \Str::random(60),
                ])->save();
            });
        } catch (QueryException $qe) {
            throw $qe;
        } catch (Exception $e) {
            throw $e;
        }
    }
}