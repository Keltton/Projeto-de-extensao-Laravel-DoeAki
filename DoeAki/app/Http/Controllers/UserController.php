<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Doacao;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Dashboard do usuário
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Eventos ativos (usando a tabela inscricoes)
        $eventosAtivos = Evento::where('data_evento', '>=', now())
            ->where('status', 'ativo')
            ->get()
            ->map(function ($evento) use ($user) {
                $inscricao = DB::table('inscricoes')
                    ->where('evento_id', $evento->id)
                    ->where('user_id', $user->id)
                    ->where('status', 'confirmada')
                    ->first();

                $evento->usuario_inscrito = !is_null($inscricao);
                $evento->inscricao_id = $inscricao->id ?? null;
                return $evento;
            });

        // Doações do usuário (últimas 5)
        $minhasDoacoes = Doacao::with('item.categoria')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Estatísticas
        $totalDoacoes = Doacao::where('user_id', $user->id)->count();
        $doacoesAceitas = Doacao::where('user_id', $user->id)->where('status', 'aceita')->count();

        // Eventos inscritos (usando a tabela inscricoes)
        $eventosInscritos = DB::table('inscricoes')
            ->where('user_id', $user->id)
            ->where('status', 'confirmada')
            ->count();

        return view('user.dashboard', compact(
            'user',
            'eventosAtivos',
            'minhasDoacoes',
            'totalDoacoes',
            'doacoesAceitas',
            'eventosInscritos'
        ));
    }

    /**
     * Meus eventos (histórico e atuais)
     */
    public function meusEventos()
    {
        $user = Auth::user();

        // SOLUÇÃO SEGURA: Usando DB direto para evitar erro de relacionamento
        $eventosInscritosQuery = DB::table('inscricoes')
            ->where('user_id', $user->id)
            ->where('status', 'confirmada')
            ->join('eventos', 'inscricoes.evento_id', '=', 'eventos.id')
            ->where('eventos.status', 'ativo')
            ->select('eventos.*', 'inscricoes.id as inscricao_id', 'inscricoes.data_inscricao')
            ->orderBy('inscricoes.created_at', 'desc');

        $eventosInscritos = $eventosInscritosQuery->paginate(10);

        // Verificar em quais eventos o usuário está inscrito (para o botão de cancelar)
        $userInscrito = DB::table('inscricoes')
            ->where('user_id', $user->id)
            ->where('status', 'confirmada')
            ->pluck('evento_id')
            ->toArray();

        return view('user.eventos.meus', compact('eventosInscritos', 'userInscrito'));
    }

    /**
     * Exibir perfil
     */
    public function perfil()
    {
        $user = Auth::user();
        $user->load('perfil'); // Carrega o relacionamento perfil
        return view('user.perfil', compact('user'));
    }

    /**
     * Atualizar perfil (AGORA SALVA EM AMBAS AS TABELAS)
     */
    public function atualizarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14',
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'sobre' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'inscricao_estadual' => 'nullable|string|max:20',
            'endereco_empresa' => 'nullable|string|max:255',
            'telefone_empresa' => 'nullable|string|max:20',
        ]);

        try {
            // Atualizar dados na tabela USERS
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'sobre' => $request->sobre,
                'possui_empresa' => $request->has('possui_empresa'),
                'empresa_nome' => $request->razao_social,
                'empresa_cnpj' => $request->cnpj,
                'empresa_endereco' => $request->endereco_empresa,
                'cadastro_completo' => true,
            ]);

            // Atualizar ou criar perfil na tabela PERFIS
            $perfilData = [
                'telefone' => $request->telefone,
                'data_nascimento' => $request->data_nascimento,
                'cpf' => $request->cpf,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'possui_empresa' => $request->has('possui_empresa'),
                'razao_social' => $request->razao_social,
                'cnpj' => $request->cnpj,
                'inscricao_estadual' => $request->inscricao_estadual,
                'endereco_empresa' => $request->endereco_empresa,
                'telefone_empresa' => $request->telefone_empresa,
            ];

            if ($user->perfil) {
                $user->perfil->update($perfilData);
            } else {
                $user->perfil()->create($perfilData);
            }

            return redirect()->route('user.perfil')->with('success', 'Perfil atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }

    /**
     * Atualizar senha
     */
    public function atualizarSenha(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Senha atual incorreta.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Senha atualizada com sucesso!');
    }

    /**
     * Completar cadastro obrigatório
     */
    public function completarCadastro(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|max:14|unique:users,cpf,' . $user->id,
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:10',
        ]);

        $user->update([
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'endereco' => $request->endereco,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'cadastro_completo' => true,
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Cadastro completado com sucesso!');
    }
}