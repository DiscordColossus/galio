<html>
    <head>
    </head>
    <body>
    
        <form action="" method="post" onsubmit="return addElements()">
            <input id="inputA" type="text">
            <input id="inputB" type="text">
            aaa
            <button  type="submit" id ="add">Dodaj</button>
            <button id="stop">Wykonaj</button>
        </form>
    </body>
    <script>
    var aArray = [];
    var bArray = [];
    var addElements = function() {
            var v = document.getElementById('inputA');
            var b = document.getElementById('inputA');
            aArray.push(v);
            bArray.push(b);
        }
    var n = aArray.length;
    var y = n - 1;
    if(n == 5 || addEventListener('add') == true) {
        for(let x = 0, x > n, x++;) {
            echo = 'Dodawanie: ' + aArray[x] + bArray[y] + '<br>';
            echo = 'Odejmowanie: ' + aArray[x] - bArray[y] + '<br>';
            y--; 
        }
    }
    </script>
</html>