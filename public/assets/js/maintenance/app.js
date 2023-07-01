function changePiece(stock)
{
    if(stock != 0)
    {
        stock = JSON.parse(stock);
        document.getElementById("qte").max = parseInt(stock.stock_actuel);
        document.getElementById('maxLabel').innerHTML = `MAX: ${stock.stock_actuel} ${stock.unitie.name}`
    } else {
        document.getElementById('maxLabel').innerHTML = `--------`
    }
}
