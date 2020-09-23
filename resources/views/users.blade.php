@extends('layouts.master')
@section('content')
    @include('includes.AddDoc')
    <table id="userstable" style="margin:auto; font-family:'Times New Roman' ;" >
        <tr >
            <th>№</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Роль</th>
            <th>Пол</th>
            <th>Группа</th>
        </tr>
        @for($i=0; $i<Count($users);$i++)
            <tr style="text-align: center">
                <td>
                    {{$i}}
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style=" margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->Фамилия}}"
                           disabled>
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->Имя}}"
                           disabled>
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->Отчество}}"
                           disabled>
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->Роль}}"
                           disabled>
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->Пол}}"
                           disabled>
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px;font-size:16px" maxlength="10" autocomplete="off"
                           value="{{$users[$i]->{'Номер группы'} }}"
                           disabled>
                </td>
                <td>
                    <button class="filebtn" id="{{$users[$i]->{'Id Пользователя'} }};{{$users[$i]->Имя}}">отправить файл</button>
                </td>
            </tr>
        @endfor
    </table>
@endsection

