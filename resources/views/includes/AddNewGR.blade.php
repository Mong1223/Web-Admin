<center>
<form method="post" action="{{route('addnewgroup')}}" style="margin-top:10">
    {{csrf_field()}}
    <input type="text" name="group" placeholder="Группа" autocomplete="off" maxlength="10" required>
    <input type="text" name="idgroup" placeholder="Идентификатор" autocomplete="off" maxlength="100" required>
    <button type="submit" >Добавить</button>
</form>

</center>
