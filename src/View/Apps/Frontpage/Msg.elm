module Msg exposing (..)

import Model exposing (Mode)


type Msg
    = SetMode (Maybe Mode)
    | UpdateEmail String
    | UpdatePassword String
