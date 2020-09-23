@extends('layouts.master')
@section('content')
    @include('includes.AddNewGR')
    <style type="text/css">
        TABLE {
            border-collapse: collapse; /* Убираем двойные линии между ячейками */
        }
        TD, TH {
            padding: 3px; /* Поля вокруг содержимого таблицы */
            border: 1px solid black; /* Параметры рамки */
        }
        TH {
            background: #79d950; /* Цвет фона */
        }
    </style>
    <table style="margin:auto; font-family:'Times New Roman' ;
    font-size: 14px;
    border-radius: 10px;
    border-spacing: 0;
    text-align: center" >
        <tr >
            <th>№</th>
            <th>Номер Группы</th>
            <th>Идентификатор</th>
        </tr>
        @for($i=0; $i<Count($user);$i++)
            <tr style="text-align: center">
                <td>
                    {{$i}}
                </td>
                <td>
                    <input type="text" name="idgroup" size="10" style="margin-top:0px" maxlength="10" autocomplete="off"
                           value="{{$user[$i]->НомерГруппы}}"
                    disabled>
                </td>

                <td>
                    <form method="post" action="{{route('editgroup',[$user[$i]->ИдентификаторГруппы,$user[$i]->IDгруппы])}}"style="margin:auto " >
                        {{csrf_field()}}
                        <input type="text" name="idgroup" size="15"  maxlength="100" autocomplete="off"
                                  value="{{$user[$i]->ИдентификаторГруппы}}"
                                  >
                            <button type="submit" class="col-lg-2 col-md-3" >
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="black" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                            </svg>
                            </button>

                        <a  class="col-lg-2 col-md-3 close delete-news-button" style="color: black" href="{{route('deletegroup',[$user[$i]->IDгруппы])}}" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>

                     </form>
                </td>

            </tr>
        @endfor

    </table>


@endsection
