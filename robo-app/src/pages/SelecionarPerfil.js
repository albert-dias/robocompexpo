import React, { useState, useEffect } from 'react';
import { Animated, Image, StatusBar, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import { FontAwesome5 } from '@expo/vector-icons';
import { LinearGradient } from 'expo-linear-gradient';
import { useNavigation } from '@react-navigation/native';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/routers';

import AuthRoutes from '../routes/auth.routes';
import theme from '../global/styles/theme';

import logo from '../../assets/images/Logo-Grupo-Ecomp.png';

const styles = StyleSheet.create({
    container: {
        alignItems: 'center',
        backgroundColor: theme.colors.dirtywhite,
        flex: 1,
    },
    containerPerfil: {
        justifyContent: 'center',
        alignItems: 'center',
        width: '90%',
        flex: 1,
    },
    textoPerfil: {
        fontSize: 25,
        marginBottom: '10%',
    },
    botao: {
        width: '100%',
        height: 60,
        borderRadius: 10,
        marginBottom: 20,
    },
    submit: {
        marginRight: 40,
        marginLeft: 40,
        top: '10%',
        paddingTop: 20,
        paddingBottom: 20,
        backgroundColor: theme.colors.submit,
        borderRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.whitepure,
    },
    submitText: {
        color: theme.colors.whitepure,
        textAlign: 'center',
        fontSize: 23,
        marginLeft: '10%',
    },
    botaoPerfil: {
        flexDirection: 'row',
        justifyContent: 'flex-start',
        paddingLeft: 30,
        alignItems: 'center',
    },
    loginButton: {
        flexDirection: 'row',
        marginTop: 10,
        top: '5%',
        bottom: '5%',
    },
    loginText: {
        fontWeight: '700',
        fontSize: 18,
    },
    logo: {
        top: '5%',
    },
});

export function SelecionarPerfil({ navigation }: StackScreenProps<ParamListBase>) {
    StatusBar.setHidden(false);

    const [offset] = useState(new Animated.ValueXY({ x: 0, y: 100 }));

    useEffect(() => {
        Animated.spring(offset.y, {
            toValue: 0,
            speed: 4,
            bounciness: 15,
        }).start();
    }, []);

    return (
        <View style={styles.container}>
            <View style={styles.logo}>
                <Image source={logo} />
            </View>
            <Animated.View style={[
                styles.containerPerfil, {
                    transform: [{ translateY: offset.y }],
                },
            ]}>
                <Text style={styles.textoPerfil}>Escolha o seu perfil</Text>

                <View style={styles.botao}>
                    <TouchableOpacity
                        activeOpacity={0.7}
                        onPress={() => { navigation.navigate('EmpresaRegister') }}
                        >
                        <LinearGradient
                            colors={['#03a4a9', '#282d41']}
                            start={{ x: 0.0, y: 1.0 }}
                            end={{ x: 1.0, y: 1.0 }}
                            style={styles.submit}
                            >
                            <View style={styles.botaoPerfil}>
                                <FontAwesome5 name='laptop' size={25} color={theme.colors.whitepure} />
                                <Text style={styles.submitText}>Empresa de TI</Text>
                            </View>
                        </LinearGradient>
                    </TouchableOpacity>
                </View>

                <View style={styles.botao}>
                    <TouchableOpacity
                            activeOpacity={0.7}
                            onPress={() => { navigation.navigate('ClientRegister') }}
                    >
                        <LinearGradient
                            colors={['#03a4a9', '#282d41']}
                            start={{ x: 0.0, y: 1.0 }}
                            end={{ x: 1.0, y: 1.0 }}
                            style={styles.submit}
                        >
                            <View style={styles.botaoPerfil}>
                                <FontAwesome5 name='user' size={25} color={theme.colors.whitepure} />
                                <Text style={styles.submitText}>Clientes</Text>
                            </View>
                        </LinearGradient>
                    </TouchableOpacity>
                </View>
                <View style={styles.loginButton}>
                    <TouchableOpacity
                        style={{flexDirection:'row', alignItems:'center'}}
                    >
                        <FontAwesome5
                            style={{marginRight: 10}}
                            name={'sign-in-alt'}
                            size={20}
                            color={theme.colors.black}
                        />
                        <Text style={styles.loginText}>Já tenho cadastro</Text>
                    </TouchableOpacity>
                </View>
            </Animated.View>
        </View>
    );
}