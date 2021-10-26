// Import de pacotes
import React, { useEffect, useState, useCallback } from 'react';
import {
    ActivityIndicator, Avatar, Button,
    Text, TouchableRipple,
} from 'react-native-paper';
import { Image, ImageBackground, StyleSheet, TouchableOpacity, View } from 'react-native';
import { ScrollView } from 'react-native-gesture-handler';
import { useFocusEffect, useIsFocused } from '@react-navigation/native';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import storagefrom from '../../util/storage';
import { withAppbar } from '../../components/Appbar';
import GlobalContext from '../../context';
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import styles from './style';
import notify from '../../util/notify';
import request from '../../util/request';

// Import de imagens
import userProfile from '../../../assets/images/avatar.png';
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

const {
    profile: {
        imageProfileRef,
        loadingImageProfileRef,
        fetchImageProfile,
        fetchProfile,
    },
} = GlobalContext;

export function Profile() {
    const authState = useStateLinkUnmounted(GlobalContext.auth.authStateRef);
    const loadingImageProfile = useStateLink(loadingImageProfileRef);
    const imageProfile = useStateLink(imageProfileRef);

    const [address, setAddress] = useState(null);
    const [district, setDistrict] = useState(null);
    const [number, setNumber] = useState(null);
    const [complement, setComplement] = useState(null);
    const [city, setCity] = useState(null);
    const [state, setState] = useState(null);

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
                    <Container
                        pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <FontAwesome5
                            name='chevron-left'
                            colors={theme.colors.white}
                            size={40}
                            style={{ marginBottom: 20, marginLeft: 20, alignSelf: 'flex-start' }}
                            onPress={() => console.log('navigate(Home)')}
                            position='absolute'
                        />
                        <Image
                            source={logo}
                            resizeMode='contain'
                            style={{
                                width: 170,
                                height: 170,
                                marginTop: -30,
                                marginBottom: -50,
                            }}
                        />
                        <Text style={styles2.textStyleF}>
                            RoboComp - Perfil
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
        </>
    );
}

const styles2 = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    informacoes: {
        fontWeight: 'bold',
        fontSize: 18,
        paddingTop: '4%',
    },
    informacoes2: {
        fontSize: 18,
        width: 'auto',
        paddingRight: '6%'
    },
    btnText: {
        color: 'white',
        fontSize: 14,
        fontWeight: 'bold'
    }
});