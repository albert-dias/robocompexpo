// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Image, Text, TouchableNativeFeedback, View } from 'react-native';
import { useSpring, animated } from 'react-spring';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import * as easings from 'd3-ease';
import { useStateLink } from '@hookstate/core';
import { hideMessage, showMessage } from 'react-native-flash-message';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import PanelSlider from '../../components/PanelSlider2';
import { DIMENSIONS_HEIGHT, DIMENSIONS_WIDTH } from '../../components/Screen';
import { PanelTitle } from '../../components/GlobalCSS';
import { Button } from '../../components/Button';
import { Button2 } from '../../components/Button';
import theme from '../../global/styles/theme';
import GlobalContext from '../../context';
import useWithTouchable from '../../util/useWithTouchable';
import { InputWarning } from '../../components/InputWarning';
import request from '../../util/request';
import useToken from '../../util/useToken';
import { StateUser } from '../../context/auth';
import { FCWithAppStackNavigator } from '../AppStackNavigator';
import GlobalStyle from '../../components/GlobalStyle';
import { GroupControl, Input, TitleView, TitleWrapper } from '../../components/GlobalCSS';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/routers';

const { cpf: cpfValidator, cnpj: cnpjValidator } = require('cpf-cnpj-validator');

const AnimatedTitleWrapper = animated(TitleWrapper);
const AnimatedTitleView = animated(TitleView);
const AnimatedPanelSlider = animated(PanelSlider);

const {
    login: {
        passwordRef,
        userTypeRef,
        cpfRef,
    },
} = GlobalContext;

// let passwordRef, userTypeRef, cpfRef;

export function Login({ navigation }: StackScreenProps<ParamListBase>) {
    const cpf = useWithTouchable(cpfRef);
    const password = useWithTouchable(passwordRef);
    // const token = useToken();

    const senhaInput = useRef(null);
    const cpfInput = useRef(null);
    const [seePassword, setSeePassword] = useState(true);

    let hasError = false;

    const checkError = (flag: boolean) => {
        if (flag) {
            hasError = true;
        }
        return flag;
    };

    const [opacity, setOpacity] = useSpring(() => ({ opacity: 0 }));
    const [titleWrapper, setTitleWrapper] = useSpring(() => ({
        height: DIMENSIONS_HEIGHT
    }));
    const [panelLeft, setPanelLeft] = useSpring(() => ({
        top: 0,
        left: 0,
    }));
    const [loading, setLoading] = useState(false);


    const submit = async () => {
        interface SubmitRequest {
            result?: {
                token?: string | false;
                user?: StateUser;
            };
        }
        setLoading(true);
        try {
            console.log('LOGIN: ' + cpf.value + '\nSENHA: ' + password.value);
        } catch (e) {
            console.log(e);
        }
        setLoading(false);
    }

    useEffect(() => {
        const config = {
            duration: 500,
            easing: easings.easeCubicOut,
        };
        setPanelLeft.start({ config, left: 0 });
    }, []);

    const moveTitleToTop = async () => {
        await new Promise((r) => setTimeout(r, 500));
        setPanelLeft.start({
            top: 0,
            config: {
                duration: 500,
                easing: easings.easeSinOut,
            },
        });
        setTitleWrapper.start({
            height: 150,
            config: {
                duration: 500,
                easing: easings.easeSinOut,
            },
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
    }, []);

    return (
        <KeyboardAwareScrollView
            contentContainerStyle={{
                minHeight: '100%',
            }}>
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
                <AnimatedPanelSlider style={panelLeft}>
                    <View>
                        <PanelTitle>Acesso</PanelTitle>
                        <GroupControl>
                            <Input
                                ref={cpfInput}
                                mode='flat'
                                label='CPF/CNPJ'
                                value={cpf.value}
                                onChangeText={cpf.set}
                                underlineColor='black'
                                keyboardType='number-pad'
                                autoCapitalize='none'
                                allowFontScaling
                                onBlur={cpf.onBlur}
                                onSubmitEditing={() => senhaInput.current.focus()}
                                returnKeyType='next'
                            />
                            <InputWarning
                                text='CPF/CPNJ não pode ficar vazio'
                                valid={checkError(cpf.value === '')}
                                visible={cpf.blurred}
                            />
                            <InputWarning
                                text='CPF/CPNJ inválido'
                                valid={checkError(!cpfValidator.isValid(cpf.value) && !cnpjValidator.isValid(cpf.value))}
                                visible={cpf.blurred}
                            />
                        </GroupControl>
                        <GroupControl>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end', width: '90%' }}>
                                <Input
                                    ref={senhaInput}
                                    mode='flat'
                                    label='Senha'
                                    value={password.value}
                                    onChangeText={password.set}
                                    underlineColor='black'
                                    allowFontScaling
                                    textContentType='password'
                                    autoCompleteType='password'
                                    secureTextEntry={seePassword}
                                    onBlur={password.onBlur}
                                    onSubmitEditing={submit}
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
                                text='Senha não pode ser vazia'
                                valid={checkError(password.value === '')}
                                visible={password.blurred}
                            />
                        </GroupControl>
                        <GroupControl>
                            <Button
                                onPress={submit}
                                text='ENTRAR'
                                fullWidth
                                disabled={hasError || loading}
                                loading={loading}
                                backgroundColor={theme.colors.newcolor}
                            />
                        </GroupControl>
                        <GroupControl>
                            <View style={{
                                flexDirection: 'row',
                                alignSelf: 'center',
                                justifyContent: 'space-between',
                                width: '90%'
                            }}>
                                <Button2
                                    onPress={() => { console.log('navigate(Recover)') }}
                                    text='RECUPERAR SENHA'
                                    backgroundColor={theme.colors.middlecolor}
                                />
                                <Button2
                                    onPress={() => navigation.navigate('SelecionarPerfil') }
                                    text='CRIAR CONTA'
                                    backgroundColor={theme.colors.middlecolor}
                                />
                            </View>
                        </GroupControl>
                    </View>
                </AnimatedPanelSlider>
            </GlobalStyle>
        </KeyboardAwareScrollView>
    );
}