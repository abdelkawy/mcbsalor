<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>LOR-Account details notifier</title>
</head>
<body>

<h3>{{__('Learning Objects Repository')}} - {{__('Account details')}}:</h3>
<p>{{__('Username')}}: {{ $username }}</p>
<p>{{__('Password')}}: {{ $password }}</p>

<p>{{__('URL')}}: <a href="http://lor.mcbs.edu.om">http://lor.mcbs.edu.om</a> </p>
</body>
</html>
