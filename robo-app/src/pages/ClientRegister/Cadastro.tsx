// Import de pacotes
import React, { useRef, useState } from 'react';
import { Alert, Image, ScrollView, StyleSheet, Text, TouchableNativeFeedback, View } from 'react-native';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/native';
import { GooglePlacesAutocomplete } from 'react-native-google-places-autocomplete';
import { getStatusBarHeight } from 'react-native-iphone-x-helper';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import { TextInputMask } from 'react-native-masked-text';
import emailValidator from 'email-validator';

// Import de páginas
import GlobalStyle from '../../components/GlobalStyle';
import Container, { ContainerTop } from '../../components/Container';
import { PanelSlider } from '../../components/PanelSlider';
import { Button } from '../../components/Button';
import { GroupControl, Input } from '../../components/GlobalCSS';
import { InputWarning } from '../../components/InputWarning';
import theme from '../../global/styles/theme';
import api from '../../services/api';

// Import de Imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';

const { cnpj: cnpjValidator, cpf: cpfValidator } = require('cpf-cnpj-validator');

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
    anuncioIcon: {
        flex: 1,
        marginHorizontal: 5,
        justifyContent: 'center'
    },
});

export function ClientRegister({ navigation }: StackScreenProps<ParamListBase>) {
    //Variáveis
    const [loading, setLoading] = useState(false);

    //Vairáveis para passar de um campo para outro
    //Passo1
    const cpfInputRef = useRef(null);
    const fullNameRef = useRef(null);
    const telefoneRef = useRef(null);
    //Passo 2
    const emailInputRef = useRef(null);
    const passwordInputRef = useRef(null);
    const confirmPasswordInputRef = useRef(null);
    const [seePassword, setSeePassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    // Variáveis do Blur
    const [fullNameBlur, setFullNameBlur] = useState(false);
    const [nomeBlur, setNomeBlur] = useState(false);
    const [phoneBlur, setPhoneBlur] = useState(false);
    const [emailBlur, setEmailBlur] = useState(false);
    const [passwordBlur, setPasswordBlur] = useState(false);
    const [confirmPasswordBlur, setConfirmPasswordBlur] = useState(false);
    const [CPFBlur, setCPFBlur] = useState(false);
    const [birthDayBlur, setBirthDayBlur] = useState(false);

    //Vairáveis do passo 1
    const [fullName, setFullName] = useState('');
    const [nome, setNome] = useState('');
    const [phone, setPhone] = useState('');
    const [cpf, setCPF] = useState('');
    const [birthDay, setBirthDay] = useState('');

    //Vairáveis do endereço
    const [address, setAddress] = useState('');
    const [number, setNumber] = useState('');
    const [complement, setComplement] = useState('');
    const [district, setDistrict] = useState('');
    const [city, setCity] = useState('');
    const [state, setState] = useState('');
    const [cep, setCEP] = useState('');
    const [lat, setLat] = useState(0);
    const [long, setLong] = useState(0);

    //Variáveis do passo 2
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [pass, setPass] = useState(0);
    const [confirmPassword, setConfirmPassword] = useState('');

    //Variáveis auxiliares
    const [v, setV] = useState(false);
    const [filter, setFilter] = useState(false);

    let hasErrors = false;

    // Variável que guarda a chave para o uso do Google Maps
    let apiKey = 'AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y';

    const checkError = (flag: boolean) => {
        if (flag) { hasErrors = true; }
        return flag;
    };

    const submit = async () => {

        let cpfT = cpf.replace(/\D/g,"");

        try {
            const response = await api.post('user', {
                plan_id: 1,
                user_type_id: 2,
                password,
                name: nome,
                lastname: fullName,
                email,
                document: cpfT,
                birth: birthDay,
                phone : phone.replace(/\D/g,""),
                origin: 'mobile',

                street: address,
                number,
                district,
                city,
                state,
                zipcode: cep.replace(/\D/g,""),
                lat,
                long,
            });

            navigation.navigate('Login');
        } catch (e) { console.log('RESPOSTA: %s', e.response.data.message); }

    }

    function localization() {
        return (<GooglePlacesAutocomplete
            placeholder='Search'
            onPress={(data, details = null) => {
                [
                    setAddress(details.address_components[1].short_name),
                    setNumber(details.address_components[0].short_name),
                    setDistrict(details.address_components[2].short_name),
                    setCity(details.address_components[3].short_name),
                    setState(details.address_components[4].short_name),
                    setCEP(details.address_components[6].short_name),
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

    return (
        <>
            <GlobalStyle>
                <ScrollView
                    style={{ marginTop: getStatusBarHeight() }}
                    keyboardShouldPersistTaps='always'
                >
                    <ContainerTop style={{ backgroundColor: 'rgba(0,0,0,0)' }}>
                        <Container
                            pb
                            style={{
                                flexDirection: 'column',
                                alignItems: 'flex-start',
                                justifyContent: 'center',
                                width: '100%',
                            }}>
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
                                RoboComp - Cadastrar Usuário
                            </Text>
                        </Container>
                    </ContainerTop>
                    <View>
                        <PanelSlider style={{ marginTop: 20 }}>
                            {/* Passo 1 */}
                            {/* GroupControl Primeiro Nome */}
                            <GroupControl>
                                <Input
                                    mode='flat'
                                    label='Primeiro Nome'
                                    value={nome}
                                    onChangeText={text => setNome(text)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onBlur={() => setNomeBlur(true)}
                                    onFocus={() => setNomeBlur(false)}
                                    onSubmitEditing={() => { fullNameRef.current.focus() }}
                                />
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(nome === '')}
                                    visible={nomeBlur}
                                />
                            </GroupControl>

                            <GroupControl>
                                <Input
                                    ref={fullNameRef}
                                    mode='flat'
                                    label='Sobrenome'
                                    value={fullName}
                                    onChangeText={text => setFullName(text)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onBlur={() => setFullNameBlur(true)}
                                    onFocus={() => setFullNameBlur(false)}
                                    onSubmitEditing={() => { telefoneRef.current._inputElement.focus() }}
                                />
                                <InputWarning
                                    text='Campo obrigatório'
                                    valid={checkError(nome === '')}
                                    visible={fullNameBlur}
                                />
                            </GroupControl>

                            {/* Passo 3 */}
                            {/* GroupControl Telefone */}
                            <GroupControl>
                                <TextInputMask
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
                                    ref={telefoneRef}
                                    placeholder='DDD + número'
                                    value={phone}
                                    onChangeText={text => setPhone(text)}
                                    onBlur={() => { setPhoneBlur(true) }}
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
                                    onBlur={() => { setEmailBlur(true) }}
                                    onFocus={() => { setEmailBlur(false) }}
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

                            {/* GroupControl CPF/CNPJ */}
                            <View style={{
                                flexDirection: 'row',
                                alignItems: 'center',
                                alignSelf: 'center',
                                width: '100%',
                                justifyContent: 'center',
                                height: 'auto',
                            }}>
                                {(!filter) ?
                                    <GroupControl>
                                        {/* GroupControl passo 2 com CNPJ */}
                                        <View style={{ flexDirection: 'column', width: '100%' }}>
                                            <View style={{ flexDirection: 'row', justifyContent: 'center' }}>
                                                <Text style={{ marginHorizontal: 10 }}>CNPJ</Text>
                                                <TouchableOpacity
                                                    style={styles.anuncioIcon}
                                                    onPress={() => { setFilter(!filter), setCPF(String(cpf).slice(0, 14)) }}
                                                >
                                                    <FontAwesome5
                                                        name='toggle-off'
                                                        color={theme.colors.green}
                                                        size={25}
                                                    />
                                                </TouchableOpacity>
                                                <Text style={{ marginHorizontal: 10 }}>CPF</Text>
                                            </View>

                                            <TextInputMask
                                                type={'custom'}
                                                options={{
                                                    mask: '99.999.999/9999-99',
                                                }}
                                                customTextInput={Input}
                                                customTextInputProps={{
                                                    mode: 'flat',
                                                    label: 'CNPJ',
                                                    underlineColor: theme.colors.black,
                                                    allowFontScaling: true,
                                                }}
                                                placeholder='00.000.000/0000.00'
                                                value={cpf}
                                                onChangeText={text => setCPF(text)}
                                                onBlur={() => { setCPFBlur(true); setV(false) }}
                                                ref={cpfInputRef}
                                                onSubmitEditing={() => {
                                                    console.log(String(cpf).replace(/[^0-9]+/g, ''));
                                                    setV(false);
                                                }}
                                            />
                                        </View>
                                        <InputWarning
                                            text="Campo Obrigatório"
                                            valid={checkError(cpf === '')}
                                            visible={CPFBlur}
                                        />
                                        <InputWarning
                                            text="CNPJ Inválido"
                                            valid={checkError(!cnpjValidator.isValid(cpf) && cpf !== '')}
                                            visible={CPFBlur}
                                        />
                                        <InputWarning
                                            text="CNPJ já cadastrado"
                                            valid={checkError(v)}
                                            visible={v}
                                        />
                                    </GroupControl>
                                    :
                                    <View style={{ flexDirection: 'column', width: '100%' }}>
                                        {/* GroupControl passo 2 com CPF */}
                                        <GroupControl>
                                            <View style={{ flexDirection: 'column', width: '100%' }}>
                                                <View style={{ flexDirection: 'row', justifyContent: 'center', alignItems: 'center' }}>
                                                    <Text style={{ marginHorizontal: 10 }}>CNPJ</Text>
                                                    <TouchableOpacity
                                                        style={styles.anuncioIcon}
                                                        onPress={() => { setFilter(!filter) }}
                                                    >
                                                        <FontAwesome5
                                                            name='toggle-on'
                                                            color={theme.colors.green}
                                                            size={25}
                                                        />
                                                    </TouchableOpacity>
                                                    <Text style={{ marginHorizontal: 10 }}>CPF</Text>
                                                </View>

                                                <TextInputMask
                                                    type={'custom'}
                                                    options={{
                                                        mask: '999.999.999-99',
                                                    }}
                                                    customTextInput={Input}
                                                    placeholder='000.000.000-00'
                                                    customTextInputProps={{
                                                        mode: 'flat',
                                                        label: 'CPF',
                                                        underlineColor: theme.colors.black,
                                                        allowFontScaling: true,
                                                    }}
                                                    value={cpf}
                                                    onChangeText={text => setCPF(text)}
                                                    onBlur={() => { cpf; setV(false) }}
                                                    ref={cpfInputRef}
                                                    onSubmitEditing={() => {
                                                        console.log(String(cpf).replace(/[^0-9]+/g, ''));
                                                        setV(false);
                                                    }}
                                                />
                                                <InputWarning
                                                    text="Campo Obrigatório"
                                                    valid={checkError(cpf === '')}
                                                    visible={CPFBlur}
                                                />
                                                <InputWarning
                                                    text="CPF Inválido"
                                                    valid={checkError(!cpfValidator.isValid(cpf)) && cpf !== ''}
                                                    visible={CPFBlur}
                                                />
                                                <InputWarning
                                                    text="CPF já cadastrado"
                                                    valid={checkError(v)}
                                                    visible={v}
                                                />
                                            </View>
                                        </GroupControl>

                                        {/* GroupControl Data de Nascimento */}
                                        <GroupControl>
                                            <TextInputMask
                                                type='datetime'
                                                options={{ format: 'DD/MM/YYYY' }}
                                                customTextInput={Input}
                                                placeholder='DD/MM/YYYY'
                                                customTextInputProps={{
                                                    mode: 'flat',
                                                    label: 'Data de Nascimento',
                                                    underlineColor: theme.colors.black,
                                                    allowFontScaling: true,
                                                }}
                                                value={birthDay}
                                                onChangeText={text => { setBirthDay(text) }}
                                                onBlur={() => setBirthDayBlur(true)}
                                                onFocus={() => setBirthDayBlur(false)}
                                            />
                                            <InputWarning
                                                text="Campo obrigatório"
                                                valid={checkError(birthDay === '')}
                                                visible={birthDayBlur}
                                            />
                                            <InputWarning
                                                text="Data em formato inválido, utilize o padrão DD/MM/YYYY"
                                                valid={checkError(!/\d\d\/\d\d\/\d\d\d\d/.test(birthDay))}
                                                visible={birthDayBlur}
                                            />
                                        </GroupControl>
                                    </View>
                                }
                            </View>

                            {/* Passo 2 */}
                            {/* GroupControl da Localização */}
                            <View style={{ flexDirection: 'row', alignItems: 'center', marginTop: 10 }}>
                                <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                                <View>
                                    <Text style={{ width: 70, textAlign: 'center', color: '#A2A2A2' }}>Endereço</Text>
                                </View>
                                <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                            </View>

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
                                    // disabled={hasErrors}
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