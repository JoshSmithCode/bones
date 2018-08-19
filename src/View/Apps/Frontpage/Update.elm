module Update exposing (update)

import Model exposing (Model)
import Msg exposing (..)


update : Msg -> Model -> (Model, Cmd Msg)
update msg model =

    case msg of

        SetMode mode ->

            { model | mode = mode } ! []

        UpdateEmail email ->

            { model | email = email } ! []

        UpdatePassword password ->

            { model | password = password } ! []