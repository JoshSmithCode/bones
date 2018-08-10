module Model exposing (Model, initial)


type alias Model =
    { loginEmail : String
    , loginPassword : String
    , signupEmail : String
    , signupPassword : String
    }


initial : Model
initial =
    { loginEmail = ""
    , loginPassword = ""
    , signupEmail = ""
    , signupPassword = ""
    }