// Import de pacotes
import React, { useEffect, useState } from 'react';
import { Button, Text } from 'react-native-paper';
import { Image, ImageBackground, ScrollView, StyleSheet, TouchableOpacity, View } from 'react-native';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';
import { showMessage } from 'react-native-flash-message';
import { TextInputMask } from 'react-native-masked-text';

// Import de páginas
import { Input } from '../../components/GlobalCSS';
import { FCWithLoggedStackNavigator } from '../LoggedStackNavigator';
import GlobalContext from '../../context';
import Container, { Containerp, ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import styles from './style';
import request from '../../util/request';
import AddressForm from '../../components/AddressForm';
import useWithTouchable from '../../util/useWithTouchable';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

const styles2 = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    inputText: {
        width: '100%',
        height: 50,
        textAlign: 'left',
        backgroundColor: '#fff',
        paddingLeft: 0,
        borderBottomWidth: 1,
        borderBottomColor: 'black',
        textAlignVertical: 'bottom',
        fontSize: 16
    },
});

let profileRef, editableProfileRefcepRef,
    addressRef, numberRef, cepRef, complementRef, districtRef,
    cityRef, stateRef, latitudeRef, longitudeRef, unregisteredUserIdRef,
    nameRef, apelidoRef, emailRef, phoneRef, clearForm;

export function EditProfile() {

    const address = useWithTouchable(addressRef);
    const cep = useWithTouchable(cepRef);
    const complement = useWithTouchable(complementRef);
    const city = useWithTouchable(cityRef);
    const district = useWithTouchable(districtRef);
    const latitude = useWithTouchable(latitudeRef);
    const longitude = useWithTouchable(longitudeRef);
    const number = useWithTouchable(numberRef);
    const state = useWithTouchable(stateRef);

    const [address2, setAddress2] = useState('');
    const [cep2, setCep2] = useState('');
    const [complement2, setComplement2] = useState('');
    const [city2, setCity2] = useState('');
    const [district2, setDistrict2] = useState('');
    const [latitude2, setLatitude2] = useState('');
    const [longitude2, setLongitude2] = useState('');
    const [number2, setNumber2] = useState('');
    const [state2, setState2] = useState('');

    const [name, setName] = useState(useWithTouchable(nameRef));
    const [apelido, setApelido] = useState(useWithTouchable(apelidoRef));
    const [email, setEmail] = useState(useWithTouchable(emailRef));
    const [phone, setPhone] = useState(useWithTouchable(phoneRef));

    const profile = useStateLink(profileRef);
    const texto = ' ';
    var textoN, textoA, textoE, textoP;

    function numberPhone(num: string) {
        num = num.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
        if (num.length < 16) { setPhone(num.toString()); }
    }

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
                        <Text style={styles2.textStyleF}>RoboComp - Editar Perfil</Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <View style={styles.container}>
                    <View style={styles.containerName}>
                        <Text style={styles.text}>Nome:</Text>
                    </View>
                    <Input style={styles2.inputText}
                        value={name}
                        onChangeText={(text) => setName(text)}
                    />
                    <View style={styles.containerName}>
                        <Text style={styles.text}>Apelido:</Text>
                    </View>
                    <Input style={styles2.inputText}
                        value={apelido}
                        onChangeText={(text) => setApelido(text)}
                    />
                    <View style={styles.containerName}>
                        <Text style={styles.text}>Email:</Text>
                    </View>
                    <Input style={styles2.inputText}
                        value={email}
                        onChangeText={(text) => setEmail(text)}
                        keyboardType='email-address'
                    />
                    <View style={styles.containerName}>
                        <Text style={styles.text}>Telefone:</Text>
                    </View>
                    <Input style={styles2.inputText}
                        value={phone}
                        onChangeText={(text) => numberPhone(text)}
                        keyboardType='phone-pad'
                    />
                </View>
                {/* <AddressForm
                    cep={(cep.value) ? cep2 : cep.value}
                    address={(address.value) ? address2 : address.value}
                    number={(number.value === '') ? number2 : number.value}
                    complement={(complement.value === '') ? complement2 : complement.value}
                    neighborhood={(district.value === '') ? district2 : district.value}
                    city={(city.value === '') ? city2 : city.value}
                    state={(state.value === '') ? state2 : state.value}
                    setCep={cep.set}
                    setAddress={address.set}
                    setNumber={number.set}
                    setComplement={complement.set}
                    setNeighborhood={district.set}
                    setCity={city.set}
                    setState={state.set}
                    setLatitude={latitude.set}
                    setLongitude={longitude.set}
                /> */}
                <View>
                    <View style={styles.divwhitebtn} />
                    <Button style={styles.btn} onPress={() =>
                        console.log('updatePerfil()')}>
                        <Text
                            style={{
                                color: 'white',
                                fontSize: 14,
                            }}>
                            SALVAR
                        </Text>
                    </Button>
                </View>
                <View style={styles.divwhite} />
            </ScrollView>
        </>
    );
}