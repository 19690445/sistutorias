<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Tutor;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EstudiantesImport;
use App\Imports\GruposImport;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;

class GrupoController extends Controller
{
 
    public function index()
    {
        $grupos = Grupo::all();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $tutores = Tutor::all();
        $periodos = Periodo::all();
        return view('grupos.create', compact('tutores', 'periodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave_grupo' => 'required|string|max:20|unique:grupos,clave_grupo',
            'nombre_grupo' => 'required|string|max:100',
            'tutores_id' => 'required|exists:tutores,id',
            'periodo_id' => 'required|exists:periodo,id',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'turno' => 'required|in:matutino,intermedio,vespertino',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo creado correctamente');
    }

    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $tutores = Tutor::all();
        $periodos = Periodo::all();
        return view('grupos.edit', compact('grupo', 'tutores', 'periodos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'clave_grupo' => 'required|string|max:20|unique:grupos,clave_grupo,' . $id,
            'nombre_grupo' => 'required|string|max:100',
            'tutores_id' => 'required|exists:tutores,id',
            'periodo_id' => 'required|exists:periodo,id',
            'carrera' => 'required|string|max:100',
            'semestre' => 'required|integer',
            'modalidad' => 'required|in:presencial,virtual,mixta',
            'turno' => 'required|in:matutino,intermedio,vespertino',
        ]);

        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo eliminado correctamente.');
    }

    public function formImportar($grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);
        return view('grupos.importar', compact('grupo'));
    }

    public function importarExcel(Request $request, $grupoId)
{
    $request->validate([
        'archivo' => ['required', File::types(['csv', 'xls', 'xlsx'])],
    ]);

    $grupo = Grupo::findOrFail($grupoId);

    try {
        $data = Excel::toArray([], $request->file('archivo'))[0];
        #dd($data);
        $expectedHeaders = ['matricula', 'nombre', 'apellidos','curp','fecha_nacimiento','genero','correo_institucional','telefono_celular','domicilio','carrera','semestre','estado'];

        $headers = array_map('strtolower', $data[0]);

        foreach ($expectedHeaders as $expectedHeader) {
            if (!in_array($expectedHeader, $headers)) {
                return back()->with('error', "Falta la columna: $expectedHeader");
            }
        }

        DB::beginTransaction();

        foreach (array_slice($data, 1) as $row) {

         
            if (count(array_filter($row)) == 0) continue;

            if (count($row) < 11) continue;

            [$matricula, $nombre, $apellidos, $curp, $fechanacimiento, $genero, $email, $telefono, $domicilio, $carrera, $semestre, $estado, ] = $row;

            if (!$email) continue;

            #dump($row);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => trim($nombre . ' ' . $apellidos),
                    'password' => Hash::make('12345678'),
                    'rol' =>4,
                ]
            );
            #dump($user);

            $estudiante = Estudiante::updateOrCreate(
                ['users_id' => $user->id],
                [
                    'matricula' => $matricula,
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'curp' => $curp,
                    'fecha_nacimiento' => $fechanacimiento,
                    'genero' => $genero,
                    'grupo_id' => $grupoId,
                    'correo_institucional' => $email,
                    'telefono_celular' => $telefono,
                    'domicilio' => $domicilio,
                    'carrera' => $carrera,
                    'semestre' => $semestre,
                    'estado' => 'activo',
                    
                    
                ]
            );
            
            if($estudiante->isDirty()){
                $estudiante->save();
            }
            #dump($estudiante, $domicilio, $estudiante->domicilio);

            // foreach($expectedHeaders as $eh){
            //     if($$eh != $estudiante->$eh){
            //         dump($eh, $estudiante->id, $$eh, $estudiante->$eh);
            //         dump("El estudiante tiene cambios", $estudiante->isDirty());
            //    }
            //}
        }

        DB::commit();
        ##dd("ALTO");
        return back()->with('success', 'Estudiantes importados correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());
        return back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
    }
}


    public function show($id)
    {
        $grupo = Grupo::with('estudiantes')->findOrFail($id);
        return view('grupos.show', compact('grupo'));
    }

}
