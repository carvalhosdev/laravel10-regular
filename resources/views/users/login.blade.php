<x-layout>
    <form action="/users/authenticate" method="post" class="mt-10">
        @csrf

        <label>Email</label>
        <input type="email" value="{{old('email')}}" name="email" class="border"  />
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
        <br><br>
        <label for="">Senha</label>
        <input type="password" value="{{old('password')}}" name="password" class="border" />
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
        <br><br>

        <button type="submit" class="bg-cyan-200 p-2">Entrar</button>
        <a href="/users/forgot">Esqueceu a senha?</a>
    </form>
</x-layout>