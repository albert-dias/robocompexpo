// Import de pacotes
import React, { useEffect, useState } from "react";
import { Image, ImageBackground, SafeAreaView, StyleSheet, TouchableWithoutFeedback, View } from "react-native";
import { Text } from "react-native-paper";
import { ScrollView, TouchableOpacity } from "react-native-gesture-handler";
import { FontAwesome5 } from '@expo/vector-icons';
import { LinearGradient } from "expo-linear-gradient";
import styled from "styled-components/native";
import { animated } from 'react-spring';

// Import de páginas
import Container, { ContainerTop } from "../../components/Container";
import theme from "../../global/styles/theme";

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logoBranca from '../../../assets/images/logo_branca_robocomp.png';

//--------------------------
//-----Início do código-----
//--------------------------

export function Home() {
    return (
        <View style={{ flexGrow: 1 }}>
            <ScrollView style={styles.scrollView}>
                {/* Até o  fechar o ContainerTop é a parte do cabeçalho da página*/}
                <ContainerTop>
                    <ImageBackground
                        source={imgBanner}
                        style={{
                            width: '100%',
                            justifyContent: 'center',
                            alignItems: 'center'
                        }}
                    >
                        <Container pb
                            style={{
                                flexDirection: 'column',
                                alignItems: 'center',
                                justifyContent: 'center',
                                width: '100%'
                            }}
                        >
                            <Image
                                source={logoBranca}
                                resizeMode="contain"
                                style={{
                                    width: 170,
                                    height: 170,
                                    marginTop: -30,
                                    marginBottom: -50
                                }}
                            />
                            <Text style={styles.textStyleF}>
                                RoboComp - Gestão de Serviços de TI
                            </Text>
                        </Container>
                    </ImageBackground>
                </ContainerTop>
                {/* Até o  fechar o ScrollView é a parte do meio da página*/}
                <View style={styles.viewn}>
                    <View style={styles.duplocontainer}>
                        <View style={styles.itemsContainer}>
                            <View style={styles.itemsRow}>
                                {/* Botão de SOLICITAR SERVIÇOS */}
                                <TouchableOpacity
                                    activeOpacity={0.7}
                                    onPress={() => { console.log('Solicitar Serviços') }} //Mudar para a página depois
                                >
                                    <LinearGradient
                                        colors={['#282D41', '#03A4A9']}
                                        start={{ x: 0.0, y: 0.0 }}
                                        end={{ x: 0.0, y: 1.0 }}
                                        style={styles.gradient}
                                    >
                                        <View style={styles.gradientItems}>
                                            <FontAwesome5
                                                name='wrench'
                                                size={56}
                                                color={'white'}
                                                style={styles.iconGradient}
                                            />
                                            <Text style={styles.gradientTexts}>Solicitar Serviços</Text>
                                        </View>
                                    </LinearGradient>
                                </TouchableOpacity>
                            </View>
                            <View style={styles.itemsRow}>
                                {/* Botão de ACOMPANHAR SERVIÇOS */}
                                <TouchableOpacity
                                    activeOpacity={0.7}
                                    onPress={() => { console.log('Acompanhar Serviços') }} //Mudar para a página depois
                                >
                                    <LinearGradient
                                        colors={['#282D41', '#03A4A9']}
                                        start={{ x: 0.0, y: 0.0 }}
                                        end={{ x: 0.0, y: 1.0 }}
                                        style={styles.gradient}
                                    >
                                        <View style={styles.gradientItems}>
                                            <FontAwesome5
                                                name='clipboard-list'
                                                size={56}
                                                color={'white'}
                                                style={styles.iconGradient}
                                            />
                                            <Text style={styles.gradientTexts}>Acompanhar Serviços</Text>
                                        </View>
                                    </LinearGradient>
                                </TouchableOpacity>
                            </View>
                        </View>
                        {/* Botão de LOJA VIRTUAL */}
                        {/* <View style={styles.itemsContainer}>
                            <View style={styles.itemsRow}>
                                <TouchableOpacity
                                    activeOpacity={0.7}
                                    onPress={() => {console.log('Loja Virtual') }}
                                >
                                    <LinearGradient
                                        colors={['#282D41', '#03A4A9']}
                                        start={{ x: 0.0, y: 0.0 }}
                                        end={{ x: 0.0, y: 1.0 }}
                                        style={styles.gradient}
                                    >
                                        <View style={styles.gradientItems}>
                                            <FontAwesome5
                                                name='store-alt'
                                                size={56}
                                                color={'white'}
                                                style={styles.iconGradient}
                                            />
                                            <Text style={styles.gradientTexts}>Loja Virtual</Text>
                                        </View>
                                    </LinearGradient>
                                </TouchableOpacity>
                            </View>
                            <View style={styles.itemsRow}>
                                <TouchableOpacity
                                    activeOpacity={0.7}
                                    onPress={() => {console.log('Alertas')}}
                                >
                                    <LinearGradient
                                        colors={['#f92e2e', '#ffacac']}
                                        start={{ x: 0.0, y: 0.0 }}
                                        end={{ x: 0.0, y: 1.0 }}
                                        style={styles.gradient}
                                    >
                                        <View style={styles.gradientItems}>
                                            <FontAwesome5
                                                name='exclamation-triangle'
                                                size={56}
                                                color={'white'}
                                                style={styles.iconGradient}
                                            />
                                            <Text style={styles.gradientTexts}>Alertas</Text>
                                        </View>
                                    </LinearGradient>
                                </TouchableOpacity>
                            </View>
                        </View> */}
                    </View>
                </View>
            </ScrollView>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: '#F4F1F0',
        height: '100%',
    },
    textStyle: {
        fontSize: 20,
        fontFamily: theme.fonts.bold,
        color: 'white',
        textAlign: 'center',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    textStyleCard: {
        fontSize: 15,
        color: 'black',
        textAlign: 'center',
    },
    viewn: {
        height: 'auto',
        justifyContent: 'space-around',
        margin: 10,
        padding: 20,
    },
    itemsContainer: {
        flex: 1,
        width: '100%',
        alignSelf: 'center',
        justifyContent: 'space-around',
        flexDirection: 'row',
        marginBottom: 20,
    },
    itemsRow: {
        flex: 1,
        height: '100%',
        alignSelf: 'center',
        flexDirection: 'column',
        justifyContent: 'space-around',
        margin: 20,
    },
    gradient: {
        borderRadius: 8,
        alignItems: 'center',
        width: '100%',
        height: '100%',
    },
    gradientItems: {
        height: 100,
        width: 100,
        flexDirection: 'column',
        alignItems: 'center',
        alignSelf: 'center',
        paddingBottom: 15
    },
    gradientTexts: {
        color: 'white',
        fontSize: 14,
        textAlign: 'center',
    },
    iconGradient: { margin: 15 },
    menu: {
        flexDirection: 'row',
        paddingVertical: 6,
        marginBottom: 10,
    },
    duplocontainer: {
        flexDirection: 'column',
        marginTop: '15%',
    }
});