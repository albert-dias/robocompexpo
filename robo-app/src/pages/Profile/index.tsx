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
import storage from '../../util/storage';

// Import de imagens
import userProfile from '../../../assets/images/avatar.png';
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import pickImage from '../../util/pickImage';
import UserProfile from '../../../assets/images/avatar.png';

export function Profile() {

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
                    }}
                >
                    <Container
                        pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}
                    >
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => { console.log('navigate(RequestServices)') }}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}
                        >
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles2.textStyleF}>RoboComp - Perfil</Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView contentContainerStyle={styles.container}>
                <View>
                    <View style={styles.divText}>
                        <TouchableOpacity onPress={() => {
                            // console.log(authState.nested.user.nested?.number_contact.set());
                            console.log('navigate(EditProfile)');
                        }}>
                            <Text>Editar perfil</Text>
                        </TouchableOpacity>
                    </View>
                    <View style={{ flexDirection: 'row' }}>
                        <View style={{ flexDirection: 'column' }}>
                            <Text style={styles2.informacoes}>Nome: </Text>
                            <Text style={styles2.informacoes}>Email: </Text>
                            <Text style={styles2.informacoes}>Telefone: </Text>
                            <Text style={styles2.informacoes}>Endereço: </Text>
                        </View>
                        <View>
                            <Text style={styles2.informacoes2}>Pessoa</Text>
                            <Text style={styles2.informacoes2}>email@email.com.br</Text>
                            <Text style={styles2.informacoes2}>(XX)9XXXX-XXXX</Text>
                            <Text style={{ marginTop: '1%', fontSize: 16, width: '60%' }}>address, number complement, district {'\n'} city/state</Text>
                        </View>
                    </View>
                    <View
                        style={{
                            width: '100%',
                            marginTop: 20,
                            marginBottom: 20,
                            height: 10,
                            backgroundColor: '#e3e5e4',
                        }}
                    />
                    <Button
                        onPress={() => {
                            console.log('navigate(EditPassword)');
                        }}
                        style={styles.btn}>
                        <Text
                            style={styles2.btnText}>
                            ALTERAR SENHA
                        </Text>
                    </Button>
                    <View style={styles.divwhitebtn} />
                    <Button
                        style={styles.btn}

                        onPress={async () => {
                            try {
                                await storage.remove('token');
                            } catch (err) {
                                console.log(err);
                            }
                            console.log('navigate(Login)');
                        }}>
                        <Text
                            style={styles2.btnText}>
                            SAIR
                        </Text>
                    </Button>
                </View>
            </ScrollView>
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