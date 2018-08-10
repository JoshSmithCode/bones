module Frontpage exposing (main)

import Html exposing (program)

import Model exposing (Model)
import Msg exposing (Msg)
import Update exposing (update)
import View exposing (view)

main : Program Never Model Msg
main =
    program
        { init = Model.initial ! []
        , update = update
        , subscriptions = always Sub.none
        , view = view
        }