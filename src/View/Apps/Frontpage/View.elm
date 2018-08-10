module View exposing (view)

import Html exposing (..)
import Html.Attributes exposing (..)
import Html.Events exposing (..)

import Model exposing (Model)
import Msg exposing (Msg)


view : Model -> Html Msg
view model =

    div
        [ class "container" ]
        [ div
            [ class "row mt-4" ]
            [ div
                [ class "col-6" ]
                [ div
                    [ class "card" ]
                    [ div
                        [ class "card-header" ]
                        [ text "Create Account" ]
                    , div
                        [ class "card-body" ]
                        [ div
                            [ class "form-group" ]
                            [ label
                                []
                                [ text "Email" ]
                            , input
                                [ type_ "text"
                                , class "form-control"
                                , value model.signupEmail
                                ]
                                []
                            ]
                        , div
                            [ class "form-group" ]
                            [ label
                                []
                                [ text "Password" ]
                            , input
                                [ type_ "password"
                                , class "form-control"
                                , value model.signupPassword
                                ]
                                []
                            ]
                        ]
                    , div
                        [ class "card-footer" ]
                        [ a
                            [ class "btn btn-success" ]
                            [ text "Signup" ]
                        ]
                    ]
                ]
            , div
                [ class "col-6" ]
                [ div
                    [ class "card" ]
                    [ div
                        [ class "card-header" ]
                        [ text "Login" ]
                    , div
                        [ class "card-body" ]
                        [ div
                            [ class "form-group" ]
                            [ label
                                []
                                [ text "Email" ]
                            , input
                                [ type_ "text"
                                , class "form-control"
                                , value model.loginEmail
                                ]
                                []
                            ]
                        , div
                            [ class "form-group" ]
                            [ label
                                []
                                [ text "Password" ]
                            , input
                                [ type_ "password"
                                , class "form-control"
                                , value model.loginPassword
                                ]
                                []
                            ]
                        ]
                    , div
                        [ class "card-footer" ]
                        [ a
                            [ class "btn btn-primary" ]
                            [ text "Login" ]
                        ]
                    ]
                ]
            ]
        ]