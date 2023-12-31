<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rols;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    const PAGINATION = 7;
    public function create(): View
    {
        return view('auth.register');
    }

    public function index(Request $request)
    {
        $busqueda = $request->get('buscarpor');
        $Usuarios = User::where('name', 'like', '%' . $busqueda . '%')->paginate($this::PAGINATION);;
        $Roless = Rols::all();
        return view('auth.index', compact('Usuarios', 'Roless', 'busqueda'));
    }
    //---


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'idrol' => 3,
        ]);
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function RegisFor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'idrol' => $request->idrol,
        ]);
        event(new Registered($user));

        Auth::login($user);
        return redirect()->route('indexU')->with('datos', '..::Registrado ..::');
    }

    //AÑADIDOS
    public function edit($id)
    {

        $Usuarios = User::findOrFail($id);
        $Roless = Rols::all();
        if (Auth::user()->rol == 0) {    //boton editar
            return view('auth.edit', compact('Usuarios','Roless'));
        } else {
            return redirect()->route('indexU')->with('datos', '..::NO ES EL ADMINISTRADOR DEL SISTEMA ..::');
        }
    }

    public function update(Request $request, $id)
    {

        $user        = User::findOrFail($id);
        $userPassword = $user->password;

        if ($request->password_actual != "") {
            $NuewPass   = $request->password;
            $confirPass = $request->confirm_password;

            //Verifico si la clave actual es igual a la clave del empleado

            if (Hash::check($request->password_actual, $userPassword)) {

                //Valido que tanto la 1 como 2 clave sean iguales
                if ($NuewPass == $confirPass) {

                    //Valido que la clave no sea Menor a 4 digitos
                    if (strlen($NuewPass) >= 4) {
                        $user->password = Hash::make($request->password);
                        $user->name = $request->name;
                        $user->idrol = $request->idrol;
                        $user->email = $request->email;
                        //guardar
                        $user->save();
                        return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente');
                    } else {
                        return redirect()->back()->with('clavemenor', 'Recuerde la clave debe ser mayor a 4 digitos');
                    }
                } else {
                    return redirect()->back()->with('ClaveIncorrecta', 'Por favor verifique las claves no coinciden');
                }
            } else {
                return redirect()->back()->withErrors(['password_actual' => 'La clave no coinciden']);
            }
        } else {
            //Solo modificaremos el nombre o el rol
            $user->name = $request->name;
            $user->idrol = $request->idrol;
            $user->email = $request->email;
            //guardar
            $user->save();
            return redirect()->route('indexU')->with('datos', '..::Actualizado ..::');
        }
    }

    public function destroy($id)
    {
        $Empleado = User::findOrFail($id);
        $Empleado->delete();
        return redirect()->route('indexU')->with('datos', '..::Eliminado con Exito ..::');
    }


    public function confirmar($id)
    {
        $Usuarios = User::findOrFail($id);
        if ($Usuarios->rol != 'Administrativo') {
            if ((Auth::user()->rol == 'Administrativo')) {   //boton eliminar
                return view('auth.confirmarEmpleado', compact('Usuarios'));
            } else {
                return redirect()->route('indexU')->with('datos', '..::No Tienes Acceso::..');
            }
        } else {
            return redirect()->route('indexU')->with('datos', '..::No puedes eliminar al Administrador del Sistema::..');
        }
    }
    public function cancelar()
    {
        return redirect()->route('indexU')->with('datos', 'acciona cancelada...');
    }
}
