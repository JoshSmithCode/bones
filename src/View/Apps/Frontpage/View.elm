module View exposing (view)

import Html exposing (..)
import Html.Attributes exposing (..)
import Html.Events exposing (..)

import Model exposing (Model, Mode(..), modeToString, modeToUrl)
import Msg exposing (..)


view : Model -> Html Msg
view model =

    div
        [ class "container" ]
        [ div
            [ class "row mt-4" ]
            [ div
                [ class "col-6 offset-3" ]
                [ Maybe.map accountModal model.mode
                    |> Maybe.withDefault accountButtons
                ]
            ]
        ]


accountModal : Mode -> Html Msg
accountModal mode =

    Html.form
        [ method "post"
        , action (modeToUrl mode)
        ]
        [ div
            [ class "modal show modal-open"
            , style [("display", "block")]
            ]
            [ div
                [ class "modal-dialog" ]
                [ div
                    [ class "modal-content" ]
                    [ div
                        [ class "modal-header d-flex justify-content-between" ]
                        [ span
                            []
                            [ text (modeToString mode) ]
                        , span
                            [ class "fas fa-times"
                            , style [("cursor", "pointer")]
                            , onClick (SetMode Nothing)
                            ]
                            []
                        ]
                    , div
                        [ class "modal-body" ]
                        [ alternateMode mode
                        , div
                            [ class "form-group" ]
                            [ label
                                []
                                [ text "Email" ]
                            , input
                                [ type_ "text"
                                , class "form-control"
                                , name "email"
                                , onInput UpdateEmail
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
                                , name "password"
                                , onInput UpdatePassword
                                ]
                                []
                            ]
                        ]
                    , div
                        [ class "modal-footer" ]
                        [ button
                            [ class "btn btn-primary"
                            , type_ "submit"
                            ]
                            [ text (modeToString mode) ]
                        ]
                    ]
                ]
            ]
        , div
            [ class "modal-backdrop show" ]
            []
        ]


alternateMode : Mode -> Html Msg
alternateMode mode =

    case mode of

        Login ->
            div
                [ class "form-group d-flex justify-content-between" ]
                [ span
                    []
                    [ text "Don't have an account?" ]
                , div
                    [ class "btn btn-sm btn-success"
                    , onClick (Just CreateAccount |> SetMode)
                    ]
                    [ text "Signup Now" ]
                ]

        CreateAccount ->
            div
                [ class "form-group d-flex justify-content-between" ]
                [ span
                    []
                    [ text "Already have an account?" ]
                , div
                    [ class "btn btn-sm btn-success"
                    , onClick (Just Login |> SetMode)
                    ]
                    [ text "Login Now" ]
                ]


accountButtons : Html Msg
accountButtons =

    div
        []
        [ button
            [ onClick (Just Login |> SetMode)
            , class "btn btn-primary"
            ]
            [ text "Login" ]
        , button
            [ onClick (Just CreateAccount |> SetMode)
            , class "btn btn-success"
            ]
            [ text "Create Account" ]
        ]