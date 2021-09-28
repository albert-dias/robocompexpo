// Import de pacotes
import React, { useEffect, useState, useRef } from 'react';
import { Group, Image, ImageBackground, ScrollView, TouchableNativeFeedback, View } from 'react-native';
import { Button, Text } from 'react-native-paper';
import { FontAwesome5 } from '@expo/vector-icons';
import { hideMessage, showMessage } from 'react-native-flash-message';
import { useState as useStateLinkUnmounted } from '@hookstate/core';
import { useNavigation } from '@react-navigation/native';

// Import de páginas
import { GroupControl, Input } from '../../components/GlobalCSS';
import Container, { ContainerTop } from '../../components/Container';
import notify from '../../util/notify';
import useToken from '../../util/useToken';
import theme from '../../global/styles/theme';
import GlobalContext from '../../context';
import useWithTouchable from '../../util/useWithTouchable';
import request from '../../util/request';
import Request from '../../interfaces/Request';
import auth, { StateUser } from '../../context/auth';
import styles from './style.ts';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import { getStatusBarHeight } from 'react-native-iphone-x-helper';

let userInputRef, oldPasswordRef, confirmNewPasswordRef, newPasswordRef;

export function EditPassword() {

    const oldPasswordInputRef = useRef('');
    const newPasswordInputRef = useRef('');
    const confirmNewPasswordInputRef = useRef('');

    const [seeOldPassword, setSeeOldPassword] = useState(true);
    const [seeNewPassword, setSeeNewPassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    const userInput = useWithTouchable(userInputRef);
    const oldPassword = useWithTouchable(oldPasswordRef);
    const confirmNewPassword = useWithTouchable(confirmNewPasswordRef);
    const newPassword = useWithTouchable(newPasswordRef);
    const arePasswordsMatching = (newPassword.value === confirmNewPassword.value) ? true : false;

    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <FontAwesome5
                            name='chevron-left'
                            color={theme.colors.white}
                            size={40}
                            style={{ marginTop: '15%', marginBottom: -60, marginLeft: 20, alignSelf: 'flex-start' }}
                            onPress={() => console.log('navigate(Profile)')}
                            position="absolute"
                        />
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 170,
                                height: 170,
                                marginTop: -30,
                                marginBottom: -50,
                            }}
                        />
                        <Text style={styles.textStyleF}>
                            RoboComp - Alterar senha
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <View style={styles.container}>
                    <View style={styles.containerName}>
                        <GroupControl style={{ flexDirection: 'row', alignItems: 'flex-end', width: '90%' }}>
                            <Input
                                ref={oldPasswordInputRef}
                                secureTextEntry={seeOldPassword}
                                label='Senha atual:'
                                value={oldPassword.value}
                                onChangeText={(text) => oldPassword.set(text)}
                                returnKeyType='next'
                                onSubmitEditing={() => {
                                    newPasswordInputRef.current.focus();
                                }}
                            />
                            <TouchableNativeFeedback
                                onPressIn={() => setSeeOldPassword(false)}
                                onPressOut={() => setSeeOldPassword(true)}
                            >
                                <FontAwesome5
                                    name={(seeOldPassword) ? 'eye-slash' : 'eye'}
                                    color={theme.colors.contrast}
                                    size={30}
                                />
                            </TouchableNativeFeedback>
                        </GroupControl>
                        <GroupControl style={{ flexDirection: 'row', alignItems: 'flex-end', width: '90%' }}>
                            <Input
                                ref={newPasswordInputRef}
                                label="Nova senha:"
                                secureTextEntry={seeNewPassword}
                                value={newPassword.value}
                                onChangeText={(text) => newPassword.set(text)}
                                returnKeyType="next"
                                onSubmitEditing={() => {
                                    confirmNewPasswordInputRef.current.focus();
                                }}
                            />
                            <TouchableNativeFeedback
                                onPressIn={() => setSeeNewPassword(false)}
                                onPressOut={() => setSeeNewPassword(true)}
                            >
                                <FontAwesome5
                                    name={(seeNewPassword) ? 'eye-slash' : 'eye'}
                                    color={theme.colors.contrast}
                                    size={30}
                                />
                            </TouchableNativeFeedback>
                        </GroupControl>
                        <GroupControl style={{ flexDirection: 'row', alignItems: 'flex-end', width: '90%' }}>
                            <Input
                                ref={confirmNewPasswordInputRef}
                                secureTextEntry={seeConfirmPassword}
                                label="Confirmar senha:"
                                value={confirmNewPassword.value}
                                onChangeText={(text) => {
                                    confirmNewPassword.set(text)
                                }}
                            />
                            <TouchableNativeFeedback
                                onPressIn={() => setSeeConfirmPassword(false)}
                                onPressOut={() => setSeeConfirmPassword(true)}
                            >
                                <FontAwesome5
                                    name={(seeConfirmPassword) ? 'eye-slash' : 'eye'}
                                    color={theme.colors.contrast}
                                    size={30}
                                />
                            </TouchableNativeFeedback>
                        </GroupControl>
                        <GroupControl>
                            <Button
                                onPress={() => console.log('submit')}
                                disabled={!arePasswordsMatching || newPassword.value === ''}
                                style={{
                                    backgroundColor: theme.colors.middlecolor,
                                    borderRadius: 8,
                                    borderWidth: 1,
                                    borderColor: 'black',
                                    marginTop: '2%'
                                }}
                            >
                                <Text style={{ color: '#FFF', fontWeight: 'bold' }}>ALTERAR SENHA</Text>
                            </Button>
                        </GroupControl>
                    </View>
                </View>
            </ScrollView>
        </>
    );
}