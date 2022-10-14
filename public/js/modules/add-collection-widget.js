class Ingredient {
    constructor(name, quantity, unity) {
        this.name = name;
        this.quantity = quantity;
        this.unity = unity;
    }
}

let listIngredients = [];
let inputIngredientName = $("#step_ingredientName")
let inputIngredientQuantity = $("#step_ingredientQuantity")
let inputIngredientUnity = $("#step_ingredientUnity")

function addIngredient(){
    let name = inputIngredientName.val()
    let quantity = inputIngredientQuantity.val()
    let unity = inputIngredientUnity.val()
    if (name !== "" && quantity !== 0 && unity !== ""){
        if (quantity.length > 4) {
            confirm("La quantitée est trop grande")
            return
        } else if(unity.length > 10){
            confirm("L'unité peu contenir maximum 10 caractères")
            return
        } else if(!isInt(quantity)) {
            confirm("La quantitée doit etre un nombre")
            return
        }
        let ingredient = new Ingredient(name,quantity,unity)
        $(".ingredientList").append('<li id="'+ ingredient.name +'"><a class="deleteIngredient text-danger fas fa-times"></a> '+ ingredient.name + " " + ingredient.quantity + "" + ingredient.unity +'</li>')
        listIngredients.push(ingredient)
        inputIngredientName.val("")
        inputIngredientQuantity.val(0)
        inputIngredientUnity.val("")
    } else {
        confirm("Un champ n'a pas été remplie")
    }
}

$(".deleteIngredient").on("click", () => {
    let list = $(".ingredientList");
    let candidate = $(this);
    let item = document.getElementById(candidate);
    list.removeChild(item);
    listIngredients.pop()
})

function isInt(value) {
    return !Number.isNaN(Number.parseInt(value));
}
