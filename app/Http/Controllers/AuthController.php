<?php

namespace App\Http\Controllers;

use App\Helpers\CleanInputs;
use App\Helpers\Validator;
use App\Http\Requests\client\ClientRequest;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\State;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @abstract Obtener los datos del usuario autenticado
     * 
     * @return \App\Models\User
     * 
    */
    public static function get()
    {
        try{
            return User::find(Auth::user()->id);
        }catch(Exception){
            return null;
        }
    }

    /**
     * @abstract Consultar y retornar la vista de registro junto con los datos requeridos
     * 
     * @return \Illuminate\View\View
    */
    public function registerView()
    {
        //Consultar tipos de documento
        $document_types = DocumentType::all();

        //Consultar sexos
        $genders = Gender::all();

        //Retornar vista de registro enviando los datos requeridos
        return view("auth.register", compact('document_types','genders'));
    }

    /**
     * @abstract Redireccionar al usuario segun su rol
     * 
     * @return \Illuminate\Http\RedirectResponse
    */
    public function redirect()
    {
        // Obtener la informacion del usuario autenticado
        $user = self::get();

        /**
         * En caso de no encontrar el usuario autenticado se redirecciona al logout
        */
        if($user == null){
            Auth::logout();

            return redirect()->route("login")->with('message',[
                'status'=>'danger',
                'text'=>'¡No hemos encontrado tu informacion de usuario!'
            ]);
        }

        # Rutas segun el rol del usuario
        $routeByRole = [
            "cliente" => "clients.facturation.index",
            "gestor_PQRS" => "admin.pqrs.index",
            "repartidor" => "admin.delivery.index",
            "almacenista" => "inventory.products.index",
            "gerente" => "admin.workers.index",
        ];

        # Obtener el rol del usuario
        $role = $user->getRoleNames()[0];

        # Redireccionar segun el rol del usuario
        if (array_key_exists($role, $routeByRole)) {
            return redirect()->route($routeByRole[$role]);
        }else{
            Auth::logout();

            return redirect()->route("login")->with('message',[
                'status'=>'danger',
                'text'=>'¡No tienes permisos para acceder al sistema!'
            ]);
        }
    }

    /**
     * @abstract Registro de cliente
     * 
     * @param \App\Http\Requests\client\ClientRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
    */
    public function clientRegister(ClientRequest $request)
    {
        try{

            /**
             * Ejecutar las validaciones adicionales
            */
            if(!Validator::runInRequest($request, User::inputs())){

                // Redireccion a la vista de registro con mensaje de advertencia
                return redirect()->back()->withInput()->with('message',[
                    'status'=>'warning',
                    'text'=>'¡Verifica los campos y realiza las correcciones necesarias!'
                ]);
            }

            /**
             * Transaccion para la creacion de un cliente
             * 
             * @param ClientRequest $request
             * @return void
            */
            DB::transaction(function() use($request){
                User::create([
                    'names'=>CleanInputs::runUpper($request->names),
                    'surnames'=>CleanInputs::runUpper($request->surnames),
                    'gender_id'=>$request->gender_id,
                    'document_type_id'=>$request->document_type_id,
                    'document_number'=>$request->document_number,
                    'phone_number'=>$request->phone_number,
                    'date_birth'=>$request->date_birth,
                    'email'=>CleanInputs::runLower($request->email),
                    'password'=>Hash::make($request->password)
                ])->assignRole('cliente');
            });

            //Redireccion al login con mensaje de exito
            return redirect()->route("login")->with('message',[
                'status'=>'success',
                'text'=>'¡Registro exitoso!, por favor inicia sesión.'
            ]);

        }catch(Exception){

            //Redireccion a la vista de registro con mensaje de error
            return redirect()->back()->withInput()->with('message',[
                'status'=>'danger',
                'text'=>'! Ha ocurrido un error, contacte al administrador del sistema. !'
            ]);
        }
        
    }
}   