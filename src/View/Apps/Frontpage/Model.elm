module Model exposing (Model, initial, Mode(..), modeToString, modeToUrl)


type alias Model =
    { mode : Maybe Mode
    , email : String
    , password : String
    }


type Mode
    = Login
    | CreateAccount


initial : Model
initial =
    { mode = Nothing
    , email = ""
    , password = ""
    }


modeToString : Mode -> String
modeToString mode =

    case mode of

        Login -> "Login"

        CreateAccount -> "Create Account"


modeToUrl : Mode -> String
modeToUrl mode =

    case mode of

        Login -> "/login"

        CreateAccount -> "/signup"