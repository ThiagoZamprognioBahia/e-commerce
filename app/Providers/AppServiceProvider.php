<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Traits\CpfValidation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('cnpj', '\App\Utils\CnpjValidation@validate', 'Insira um CNPJ válido.');
        Validator::extend('cnpjConfirm', '\App\Utils\CnpjValidationConfirm@validate', 'Já existe cadastro com esse CNPJ.');
        Validator::extend('cpf', '\App\Utils\CpfValidation@validate', 'Insira um CPF válido.');
        Validator::extend('cpfConfirm', '\App\Utils\CpfValidationConfirm@validate', 'Já existe cadastro com esse CPF.');
    }
}
