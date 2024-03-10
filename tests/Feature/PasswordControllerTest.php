<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Password;
use Illuminate\Support\Facades\Crypt;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testStoreMethod()
    {
        // Criar um usuário para simular a autenticação
        $user = User::factory()->create();

        $passwordData = [
            'password_name' => 'NovaSenha',
            'password_value' => Crypt::encryptString('SenhaSecreta123', $user->encryption_key),
        ];

        
        // Criar dados de senha usando a factory e substituir o usuário pelo criado

        // Simular a autenticação do usuário
        $response = $this->actingAs($user)->post('/password', $passwordData);

        // Verificar se a resposta é um redirecionamento bem-sucedido
        $response->assertRedirect(route('home'));

        // Verificar se a senha foi criada corretamente no banco de dados
        $this->assertDatabaseHas('passwords', [
            'password_name' => $passwordData['password_name'],
            'password_value' => $passwordData['password_value'],
            'user_id' => $user->id,
        ]);

        // Obter a senha criada do banco de dados
        $storedPassword = Password::where('password_name', 'NovaSenha')->first();

        // Verificar se o valor da senha foi criptografado corretamente
        $decryptedPasswordValue = Crypt::decryptString($storedPassword->password_value, $user->encryption_key);
        $this->assertEquals('SenhaSecreta123', $decryptedPasswordValue);
    }



    public function testIndexMethod()
    {
        // Criar um usuário com uma chave de criptografia
        $encryption_key = 'chave_teste';
        $user = User::factory()->create([
            'encryption_key' =>  Crypt::encryptString($encryption_key, env('ENCRYPTION_KEY')),
            'id' => 1,
        ]);

        // Criar uma senha criptografada para o usuário
        $password_value = Crypt::encryptString('Valor da senha', $user->encryption_key);
        $password = Password::factory()->create([
            'user_id' => $user->id,
            'password_value' => $password_value,
        ]);

        // Autenticar o usuário
        $this->actingAs($user);

        // Fazer a requisição para a página "/home"
        $response = $this->get('/home');

        // Verificar se a resposta da página é 200 (OK)
        $this->assertEquals(200, $response->status());

        // Verificar se a página exibe corretamente os detalhes da senha descriptografada
        $response->assertSee($password->password_name);
        $response->assertSee('Valor da senha'); // Descriptografado com a chave de criptografia do usuário
    }


    public function testUpdateMethod()
    {
        // Cria um usuário e uma senha associada a esse usuário
        $user = User::factory()->create();
        $password = Password::factory()->create(['user_id' => $user->id]);

        // Define os novos valores para a senha
        $newPasswordName = 'Nova Senha';
        $newPasswordValue = 'NovaSenha123';

        // Simula uma requisição POST para a rota 'password.update' com os novos valores
        $response = $this->actingAs($user)->put(route('password.update', ['password_id' => $password->password_id]), [
            'new_password_name' => $newPasswordName,
            'new_password_value' => $newPasswordValue,
        ]);

        // Verifica se a senha foi atualizada corretamente no banco de dados
        $this->assertDatabaseHas('passwords', [
            'password_id' => $password->password_id,
            'password_name' => $newPasswordName,
        ]);

        // Verifica se o usuário foi redirecionado para a rota 'home' após a atualização
        $response->assertRedirect(route('home'));
    }

    public function testDestroyMethod()
    {
        $user = User::factory()->create();
        $password = Password::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/password/' . $password->password_id);

        $response->assertStatus(302);

        $deletedPassword = Password::find($password->password_id);
        $this->assertNull($deletedPassword);
    }
}
