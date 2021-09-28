// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Image, TouchableNativeFeedback, View } from 'react-native';
import { animated, useSpring } from 'react-spring';
import * as easings from 'd3-ease';
import { useState as useStateLink } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';
import { showMessage } from 'react-native-flash-message';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

// Import de páginas
import PanelSlider from '../../components/PanelSlider2';
import { DIMENSIONS_HEIGHT, DIMENSIONS_WIDTH } from '../../components/Screen';
import { PanelTitle } from '../../components/GlobalCSS';
import theme from '../../global/styles/theme';
import { Button, Button2 } from '../../components/Button';
import useWithTouchable from '../../util/useWithTouchable';
import { InputWarning } from '../../components/InputWarning';
import { GroupControl, Input, TitleView, TitleWrapper } from '../../components/GlobalCSS';
import GlobalContext from '../../context';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';
import GlobalStyle from '../../components/GlobalStyle';
import useToken from '../../util/useToken';

const { cpf: cpfValidator, cnpj: cnpjValidator } = require('cpf-cnpj-validator');

const AnimatedTitleWrapper = animated(TitleWrapper);
const AnimatedTitleView = animated(TitleView);

export function Login() {
    const {
        login: {
            cpfRef,
            emailRef,
            passwordRef,
            userTypeRef,
        },
    } = GlobalContext;

    // Variáveis
    const cpf = useWithTouchable(cpfRef);
    const password = useWithTouchable(passwordRef);
    const token = useToken();

    const senhaInput = useRef(null);
    const cpfInput = useRef(null);

    const [seePassword, setSeePassword] = useState(true);

    const [opacity, setOpacity] = useSpring(() => ({ opacity: 0 }));
    const [titleWrapper, setTitleWrapper] = useSpring(() => ({ height: DIMENSIONS_HEIGHT }));
    const [panelLeft, setPanelLeft] = useSpring(() => ({
        top: DIMENSIONS_HEIGHT,
        left: 0
    }));

    const [loading, setLoading] = useState(false);
    let hasError = false;

    // Funções da página
    const checkError = (flag: boolean) => {
        if (flag) { hasError = true; }
        return flag;
    };

    const moveTitleToTop = async () => {
        await new Promise((r) => setTimeout(r, 500));
        setPanelLeft({
            top: 0,
            config: {
                duration: 500,
                easing: easings.easeSinOut,
            }
        });
        setTitleWrapper({
            height: 150,
            config: {
                duration: 500,
                easing: easings.easeSinIn
            },
            onRest: moveTitleToTop,
        });
    };

    const showTitle = () => {
        setOpacity.start({
            opacity: 1,
            config: {
                duration: 500,
                easing: easings.easeSinIn,
            },
            onRest: moveTitleToTop,
        });
    };

    useEffect(() => {
        showTitle();
        const config = {
            duration: 500,
            easing: easings.easeCubicOut
        };
        setPanelLeft({
            config, left: 0
        });
    }, []);

    // Construção da tela
    return (
        <KeyboardAwareScrollView contentContainerStyle={{ minHeight: '100%' }}>
            <GlobalStyle>
                <AnimatedTitleWrapper style={titleWrapper}>
                    <AnimatedTitleView style={opacity}>
                        <Image
                            source={logo}
                            style={{
                                width: DIMENSIONS_WIDTH * 0.45,
                                height: 60
                            }}
                        />
                    </AnimatedTitleView>
                </AnimatedTitleWrapper>
                <PanelSlider>
                    <View>
                        <GroupControl>
                            <PanelTitle>Acesso</PanelTitle>
                        </GroupControl>
                        <GroupControl>
                            <Input
                                ref={cpfInput}
                                mode='flat'
                                label='CPF/CNPJ'
                                value={cpf.value}
                                onChangeText={cpf.set}
                                underlineColor={theme.colors.black}
                                keyboardType='number-pad'
                                autoCapitalize='none'
                                allowFontScaling
                                onBlur={cpf.onBlur}
                                onSubmitEditing={() => senhaInput.current.focus()}
                                returnKeyType='next'
                            />
                            <InputWarning
                                text='CPF/CNPJ não pode ser vazio'
                                valid={checkError(cpf.value === '')}
                                visible={cpf.blurred}
                            />
                            <InputWarning
                                text='CPF/CNPJ inválido'
                                valid={checkError(!cpfValidator.isValid(cpf.value) && !cnpjValidator.isValid(cpf.value) && cpf.value !== '')}
                                visible={cpf.blurred}
                            />
                        </GroupControl>
                        <GroupControl>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end', width: '90%' }}>
                                <Input
                                    ref={senhaInput}
                                    mode="flat"
                                    label="Senha"
                                    value={password.value}
                                    onChangeText={password.set}
                                    underlineColor="black"
                                    allowFontScaling
                                    textContentType="password"
                                    autoCompleteType="password"
                                    secureTextEntry={seePassword}
                                    onBlur={password.onBlur}
                                    onSubmitEditing={() => { }}
                                />
                                <TouchableNativeFeedback
                                    onPressIn={() => setSeePassword(false)}
                                    onPressOut={() => setSeePassword(true)}
                                >
                                    <FontAwesome5
                                        name={(seePassword) ? 'eye-slash' : 'eye'}
                                        color={theme.colors.contrast}
                                        size={30}
                                    />
                                </TouchableNativeFeedback>
                            </View>
                            <InputWarning
                                text="Senha não pode ser vazia"
                                valid={checkError(password.value === '')}
                                visible={password.blurred}
                            />
                        </GroupControl>
                        <GroupControl>
                            <Button
                                onPress={() => { }}
                                text='ENTRAR'
                                fullWidth
                                disabled={hasError || loading}
                                loading={loading}
                                backgroundColor={theme.colors.newcolor}
                            />
                        </GroupControl>
                        <View style={{
                            flexDirection: 'row',
                            alignSelf: 'center',
                            justifyContent: 'space-between',
                            width: '90%'
                        }}>
                            <Button2
                                onPress={() => { }}
                                text='RECUPERAR SENHA'
                                backgroundColor={theme.colors.middlecolor}
                            />
                            <Button2
                                onPress={() => { }}
                                text='CRIAR CONTA'
                                backgroundColor={theme.colors.middlecolor}
                            />
                        </View>
                    </View>
                </PanelSlider>
            </GlobalStyle>
        </KeyboardAwareScrollView>
    );
}