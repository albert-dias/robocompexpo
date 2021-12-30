// Import de pacotes
import React, { useEffect, useState, useRef } from 'react';
import { Image, ScrollView, StyleSheet, Text, TouchableNativeFeedback, View } from 'react-native';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { TextInputMask } from 'react-native-masked-text';
import { FontAwesome5 } from '@expo/vector-icons';
import emailValidator from 'email-validator';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/routers';

// Import de páginas
import { GroupControl, Input } from '../../components/GlobalCSS';
import { ContainerTop } from '../../components/Container';
import { PanelSlider } from '../../components/PanelSlider';
import { InputWarning } from '../../components/InputWarning';
import theme from '../../global/styles/theme';
import { Button } from '../../components/Button';
import GlobalStyle from '../../components/GlobalStyle';
import api from '../../services/api';

import logo from '../../../assets/images/logo_branca_robocomp.png';
import { GooglePlacesAutocomplete } from 'react-native-google-places-autocomplete';
import { getStatusBarHeight } from 'react-native-iphone-x-helper';

const { cnpj: cnpjValidator } = require('cpf-cnpj-validator');

const styles = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
        alignSelf: 'center',
    },
});

export function EmpresaRegister({ navigation }: StackScreenProps<ParamListBase>) {
    //Variáveis de Blur
    const [fantasyNameBlur, setFantasyNameBlur] = useState(false);
    const [corporateNameBlur, setCorporateNameBlur] = useState(false);
    const [CNPJBlur, setCNPJBlur] = useState(false);
    const [phoneBlur, setPhoneBlur] = useState(false);
    const [emailBlur, setEmailBlur] = useState(false);
    const [passwordBlur, setPasswordBlur] = useState(false);
    const [confirmPasswordBlur, setConfirmPasswordBlur] = useState(false);

    const [loading, setLoading] = useState(false);

    //Vairáveis para passar de um campo para outro
    //Passo1
    const fantasyNameRef = useRef(null);
    const corporateNameRef = useRef(null);
    const cnpjInputRef = useRef(null);
    const telefoneRef = useRef(null);
    //Passo 2
    const emailInputRef = useRef(null);
    const passwordInputRef = useRef(null);
    const confirmPasswordInputRef = useRef(null);
    const [seePassword, setSeePassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    //Vairáveis do passo 1
    const [corporateName, setCorporateName] = useState('');
    const [cnpj, setCNPJ] = useState('');
    const [fantasyName, setFantasyName] = useState('');

    //Vairáveis do endere
    const [address, setAddress] = useState('');
    const [number, setNumber] = useState('');
    const [complement, setComplement] = useState('');
    const [district, setDistrict] = useState('');
    const [city, setCity] = useState('');
    const [state, setState] = useState('');
    const [cep, setCep] = useState('');
    const [lat, setLat] = useState(0);
    const [long, setLong] = useState(0);

    //Variáveis do passo 3
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [pass, setPass] = useState(0);
    const [confirmPassword, setConfirmPassword] = useState('');
    const [phone, setPhone] = useState('');

    let hasErrors = false;

    // Variável que guarda a chave para o uso do Google Maps
    let apiKey = 'AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y';

    const checkError = (flag: boolean) => {
        if (flag) { hasErrors = true; }
        return flag;
    };

    const submit = async () => {

        let cnpjT = cnpj.replace(/\D/g,"");

        try {
            const response = await api.post('user', {
                password,
                email,
                phone : phone.replace(/\D/g,""),
                name: fantasyName,
                plan_id: 1,
                origin: 'mobile',
                lastname: corporateName,
                user_type_id: 3,
                document: cnpjT,
                birth: new Date(),

                street: address,
                number,
                district,
                city,
                state,
                zipcode: cep.replace(/\D/g,""),
                lat,
                long
            });
            console.log('RESPOSTA: %s', response.data);
            navigation.navigate('Login');
        }
        catch (e) { console.log('RESPOSTA: %s', e.response.data.message); }
    }

    function localization() {
        return (
        <GooglePlacesAutocomplete
            placeholder='Search'
            onPress={(data, details = null) => {
                [
                    // 'details' is provided when fetchDetails = true
                    setAddress(details.address_components[1].short_name),
                    setNumber(details.address_components[0].short_name),
                    setDistrict(details.address_components[2].short_name),
                    setCity(details.address_components[3].short_name),
                    setState(details.address_components[4].short_name),
                    setCep(details.address_components[6].short_name),
                    setLat(details.geometry.location.lat),
                    setLong(details.geometry.location.lng),
                ]
            }}
            fetchDetails={true}
            query={{
                key: apiKey,
                language: 'pt-BR',
            }}
        />);
    }

    const setCategorias = async () => {

    }

    useEffect(() => {
        setCategorias();
        setAddress('');
    }, []);

    return (
        <>
            <GlobalStyle>
                <ScrollView
                    style={{ marginTop: getStatusBarHeight() }}
                    keyboardShouldPersistTaps='always'
                >
                    <ContainerTop pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'flex-start',
                            justifyContent: 'center',
                            width: '100%',
                        }}
                    >
                        <View style={{ flexDirection: 'row', alignItems: 'center', width: '100%' }}>
                            <TouchableOpacity
                                onPress={() => navigation.goBack()}
                                style={{
                                    position: 'relative',
                                    alignSelf: 'flex-start',
                                    marginTop: '40%',
                                    marginLeft: '15%',
                                    alignContent: 'flex-start',
                                    alignItems: 'flex-start',
                                }}>
                                <FontAwesome5
                                    name='chevron-left'
                                    color={theme.colors.white}
                                    size={50}
                                />
                            </TouchableOpacity>
                            <Image
                                source={logo}
                                resizeMode='contain'
                                style={{
                                    alignSelf: 'center',
                                    width: 200,
                                    height: 200,
                                    marginTop: -30,
                                    marginBottom: -50,
                                    marginRight: '25%',
                                    marginLeft: 'auto',
                                }}
                            />
                        </View>
                        <Text style={styles.textStyleF}>
                            RoboComp - Cadastrar Empresa
                        </Text>
                    </ContainerTop>
                    <View>
                        <PanelSlider style={{ marginTop: 20 }}>
                            {/* Passo 1 */}
                            {/* GroupControl Nome Fantasia */}
                            <GroupControl>
                                <Input
                                    ref={fantasyNameRef}
                                    mode='flat'
                                    label='Nome Comercial'
                                    value={fantasyName}
                                    placeholder='Nome Fantasia'
                                    onChangeText={text => setFantasyName(text)}
                                    underlineColr={theme.colors.black}
                                    allowFontScaling
                                    onSubmitEditing={() => corporateNameRef.current.focus()}
                                    // onSubmitEditing={() => console.log('name: %s',JSON.stringify(fantasyName))}
                                    onBlur={() => setFantasyNameBlur(true)}
                                    onFocus={() => setFantasyNameBlur(false)}
                                />
                                <InputWarning
                                    text='Campo Obrigatório'
                                    valid={checkError(fantasyName === '')}
                                    visible={fantasyNameBlur === true}
                                />
                            </GroupControl>

                            {/* GroupControl Razão Social */}
                            <GroupControl>
                                <Input
                                    ref={corporateNameRef}
                                    mode='flat'
                                    label='Razão Social'
                                    value={corporateName}
                                    placeholder={'Nome de Registro'}
                                    onChangeText={text => setCorporateName(text)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onBlur={() => setCorporateNameBlur(true)}
                                    onFocus={() => setCorporateNameBlur(false)}
                                    onSubmitEditing={() => cnpjInputRef.current._inputElement.focus()}
                                />
                                <InputWarning
                                    text='Campo Obrigatório'
                                    valid={checkError(corporateName === '')}
                                    visible={corporateNameBlur === true}
                                />
                            </GroupControl>

                            {/* GroupControl CNPJ */}
                            <GroupControl>
                                <TextInputMask
                                    ref={cnpjInputRef}
                                    type='cnpj'
                                    customTextInput={Input}
                                    customTextInputProps={{
                                        mode: 'flat',
                                        label: 'CNPJ',
                                        underlineColor: theme.colors.black,
                                        allowFontScaling: true,
                                    }}
                                    value={cnpj}
                                    placeholder='00.000.000/0000-00'
                                    onChangeText={text => setCNPJ(text)}
                                    onBlur={() => setCNPJBlur(true)}
                                    onFocus={() => setCNPJBlur(false)}
                                    onSubmitEditing={() => {
                                        checkError(!cnpjValidator.isValid(cnpj));
                                        telefoneRef.current._inputElement.focus();
                                    }}
                                />
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(cnpj === '')}
                                    visible={CNPJBlur}
                                />
                                <InputWarning
                                    text='CNPJ inválido'
                                    valid={checkError(!cnpjValidator.isValid(cnpj))}
                                    visible={CNPJBlur}
                                />
                            </GroupControl>

                            {/* Passo 2 */}
                            {/* GroupControl Telefone */}
                            <GroupControl>
                                <TextInputMask
                                    ref={telefoneRef}
                                    type='cel-phone'
                                    options={{
                                        maskType: 'BRL',
                                        withDDD: true,
                                        dddMask: '(99) ',
                                    }}
                                    customTextInput={Input}
                                    customTextInputProps={{
                                        mode: 'flat',
                                        label: 'Telefone',
                                        underlineColor: theme.colors.black,
                                        allowFontScaling: true,
                                    }}
                                    placeholder='DDD + número'
                                    value={phone}
                                    onChangeText={text => setPhone(text)}
                                    onBlur={() => setPhoneBlur(true)}
                                    onFocus={() => setPhoneBlur(false)}
                                    onSubmitEditing={() => emailInputRef.current.focus()}
                                />
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(phone === '')}
                                    visible={phoneBlur}
                                />
                            </GroupControl>

                            {/* GroupControl Email */}
                            <GroupControl>
                                <Input
                                    ref={emailInputRef}
                                    mode='flat'
                                    keyboardType='email-address'
                                    autoCapitalize='none'
                                    label='Email'
                                    value={email}
                                    onChangeText={text => setEmail(text)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onBlur={() => setEmailBlur(true)}
                                    onFocus={() => setEmailBlur(false)}
                                    onSubmitEditing={() => passwordInputRef.current.focus()}
                                />
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(email === '')}
                                    visible={emailBlur}
                                />
                                <InputWarning
                                    text='Email inválido'
                                    valid={checkError(email !== '' && !emailValidator.validate(email))}
                                    visible={emailBlur}
                                />
                            </GroupControl>

                            {/* GroupControl Senha */}
                            <GroupControl>
                                <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                    <Input
                                        ref={passwordInputRef}
                                        style={{ width: '90%' }}
                                        mode='flat'
                                        label='Senha'
                                        value={password}
                                        placeholder='Mínimo de 6 dígitos'
                                        secureTextEntry={seePassword}
                                        onChangeText={text => { setPassword(text); setPass(text.length); }}
                                        underloneColor={theme.colors.black}
                                        allowFontScaling
                                        onBlur={() => setPasswordBlur(true)}
                                        onFocus={() => setPasswordBlur(true)}
                                        onSubmitEditing={() => confirmPasswordInputRef.current.focus()}
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
                                    text='Campo obrigatório'
                                    valid={checkError(password === '')}
                                    visible={passwordBlur}
                                />
                                <InputWarning
                                    text='Senha muito pequena'
                                    valid={checkError(pass < 6 && password !== '')}
                                    visible={passwordBlur}
                                />
                            </GroupControl>

                            {/* GroupControl Confirmar Senha */}
                            <GroupControl>
                                <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                    <Input
                                        style={{ width: '90%' }}
                                        mode='flat'
                                        label='Confirmar senha'
                                        value={confirmPassword}
                                        secureTextEntry={seeConfirmPassword}
                                        onChangeText={text => setConfirmPassword(text)}
                                        underlineColor={theme.colors.black}
                                        allowFontScaling
                                        onBlur={() => setConfirmPasswordBlur(true)}
                                        onFocus={() => setConfirmPasswordBlur(true)}
                                        ref={confirmPasswordInputRef}
                                        onSubmitEditing={() => { }}
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
                                </View>
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(confirmPassword === '')}
                                    visible={confirmPasswordBlur}
                                />
                                <InputWarning
                                    text='Senhas não conferem'
                                    valid={checkError(confirmPassword !== password)}
                                    visible={confirmPasswordBlur}
                                />
                            </GroupControl>

                            {/* Passo */}
                            <View>
                                {localization()}
                                <InputWarning
                                    text='Endereço Inválido'
                                    valid={checkError(address === '')}
                                    visible={address === ''}
                                />
                                <GroupControl>

                                    {(address === '') ?
                                        <View /> :
                                        <>
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Rua'
                                                value={address}
                                                underlineColor={theme.colors.black}
                                                allowFontScaling
                                                disabled={true}
                                            />
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Número'
                                                value={number}
                                                underlineColor={theme.colors.black}
                                                onChangeText={(text) => setNumber(text)}
                                                allowFontScaling
                                            />
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Complemento'
                                                value={complement}
                                                underlineColor={theme.colors.black}
                                                onChangeText={(text) => setComplement(text)}
                                                allowFontScaling
                                            />
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Bairro'
                                                value={district}
                                                underlineColor={theme.colors.black}
                                                allowFontScaling
                                                disabled={true}
                                            />
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Cidade'
                                                value={city}
                                                underlineColor={theme.colors.black}
                                                allowFontScaling
                                                disabled={true}
                                            />
                                            <Input
                                                style={{ width: '90%' }}
                                                mode='flat'
                                                label='Estado'
                                                value={state}
                                                underlineColor={theme.colors.black}
                                                allowFontScaling
                                                disabled={true}
                                            />
                                        </>
                                    }
                                </GroupControl>
                            </View>
                            <GroupControl>
                                <Button
                                    onPress={submit}
                                    disabled={hasErrors}
                                    text='ENVIAR'
                                    fullWidth
                                    loading={loading}
                                    backgroundColor={theme.colors.newcolor}
                                />
                            </GroupControl>
                        </PanelSlider>
                    </View>
                </ScrollView>
            </GlobalStyle>
        </>
    );
}