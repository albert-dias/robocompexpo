// Import de pacotes
import React, { useEffect, useState } from 'react';
import { Avatar, Button, Text } from 'react-native-paper';
import { Image, ImageBackground, ScrollView, StyleSheet, View } from 'react-native';
import { FontAwesome5 } from '@expo/vector-icons';
import { hideMessage, showMessage } from 'react-native-flash-message';
import { useState as useStateLink, useState as useStateLinkUnmounted } from '@hookstate/core';

// Import de páginas
import auth from '../../context/auth';
import { Input } from '../../components/GlobalCSS';
import GlobalContext from '../../context';
import theme from '../../global/styles/theme';
import styles from './style';
import AddressForm from '../../components/AddressForm';
import Container, { ContainerTop } from '../../components/Container';
import request from '../../util/request';
import useWithTouchable from '../../util/useWithTouchable';

// Import de imagens
import banner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

let profileRef, editableProfileRef, cepRef, addressRef, numberRef,
    complementRef, districtRef, cityRef, stateRef, latitudeRef, longitudeRef,
    unregisteredUserIdRef, nameRef, apelidoRef, emailRef, phoneRef, clearForm;

export function EditProfile() {

    // Variáveis
    const cep = useWithTouchable(cepRef);
    const address = useWithTouchable(addressRef);
    const number = useWithTouchable(numberRef);
    const complement = useWithTouchable(complementRef);
    const district = useWithTouchable(districtRef);
    const city = useWithTouchable(cityRef);
    const state = useWithTouchable(stateRef);
    const latitude = useWithTouchable(latitudeRef);
    const longitude = useWithTouchable(longitudeRef);

    const [cep2, setCep2] = useState('');
    const [address2, setAddress2] = useState('');
    const [number2, setNumber2] = useState('');
    const [complement2, setComplement2] = useState('');
    const [district2, setDistrict2] = useState('');
    const [city2, setCity2] = useState('');
    const [state2, setState2] = useState('');
    const [latitude2, setLatitude2] = useState('');
    const [longitude2, setLongitude2] = useState('');

    const [name, setName] = useState(useWithTouchable(nameRef));
    const [apelido, setApelido] = useState(useWithTouchable(apelidoRef));
    const [email, setEmail] = useState(useWithTouchable(emailRef));
    const [phone, setPhone] = useState(useWithTouchable(phoneRef));

    const profile = useStateLink(profileRef);
    const texto = ' ';
    var textoN, textoA, textoE, textoP;

    // Funções da página
    // Puxar o nome das informações dadas no login
    function setarNome() {
        if (name == ' ') {
            textoN = 'Arthur Felipe'; //authState.value?.user.name;
            setName(textoN);
            return name;
        }
        else return name;
    }


    // Puxar o apelido das informações dadas no login
    function setarApelido() {
        if (apelido.value == '') {
            textoA = 'Arthur'; //authState.value.user?.nickname;
            setApelido(textoA);
            return apelido;
        }
        else return apelido;
    }

    // Puxar o email das informações dadas no login
    function setarEmail() {
        if (email.value == '') {
            textoE = 'arthur@email.com'; //authState.value?.user.email;
            setEmail(textoE);
            return email;
        }
        else return email;
    }

    // Puxar o telefone das informações dadas no login
    function setarPhone() {
        if (phone.value == '') {
            textoP = '84987654321'; //authState.value?.user?.number_contact;
            setPhone(textoP);
            return phone;
        }
        else return phone;
    }

    useEffect(() => {
        setName(texto);
        setEmail(texto);
        setPhone(texto);
        setApelido(texto);
        // clearForm();
        // carregarPerfil();
    });

    /*  // Carregar as informações do perfil que já estão no banco de dados
    async function carregarPerfil(){
        try{
            const response = await request.authGet('Users/carregar');
            setCep2(response.result.user.cep);
            setAddress2(response.result.user.address);
            setNumber2(response.result.user.number);
            setComplement2(response.result.user.complement);
            setDistrict2(response.result.user.district);
            setCity2(response.result.user.city);
            setState2(response.result.user.state);
            setLatitude2(response.result.user.latitude);
            setLongitude2(response.result.user.longitude);

        }catch(e){console.log('ERRO AO CARREGAR ENDEREÇO: ' + e);}
    }

    // Atualizar as informações do perfil no banco de dados
    const updatePerfil = async() => {
        var inputCep = (cep.value === '') ? cep2 : cep.value;
        var inputAddress = (address.value === '') ? address2 : address.value;
        var inputNumber = (number.value === '') ? number2 : number.value;
        var inputComplemento = (complement.value === '') ? complement2 : complement.value;
        var inputBairro = (district.value === '') ? district2 : district.value;
        var inputCity = (city.value === '') ? city2 : city.value;
        var inputEstado = (state.value === '') ? state2 : state.value;
        var inputLong = (longitude.value === '') ? longitude2 : longitude.value;
        var inputLati = (latitude.value === '') ? latitude2 : latitude.value;

        try{
            const response = request.authPost('Users/updatePerfil', {
                nome: name,
                email: email,
                telefone: phone,
                apelido: apelido,
                cep: inputCep,
                endereco: inputAddress,
                numero: inputNumber,
                complemento: inputComplemento,
                bairro: inputBairro,
                cidade: inputCity,
                estado: inputEstado,
                longitude: inputLong,
                latitude: inputLati,
            });

            showMessage({
                message:'Informações atualizadas',
                type: 'success',
                autoHide: true,
                icon: 'success',
                duration: 3000,
            });

            // Atualizar as informações do perfil nos dados da sessão
            authState.nested.user.nested?.name.set(name);
            authState.nested.user.nested?.nickname.set(apelido);
            authState.nested.user.nested?.number_contact.set(phone);
            authState.nested.user.nested?.email.set(email);
            navigate('Profile');

        }catch(e){ console.log('ERRO DE SALVAR PERFIL' + e); }
    } */

    // Construção da página
    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={banner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center'
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%'
                        }}>
                        <FontAwesome5
                            name='chevron-left'
                            color={theme.colors.white}
                            size={40}
                            style={{ marginTop: '15%', marginBottom: -80, marginLeft: 20, alignSelf: 'flex-start' }}
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
                            RoboComp - Editar Perfil
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
        </>
    );
}