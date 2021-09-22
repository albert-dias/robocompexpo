// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Image, StyleSheet, Text, TouchableNativeFeedback, TouchableOpacity, View } from 'react-native';
import { FontAwesome5 } from '@expo/vector-icons';
import { TextInput } from 'react-native-paper';
import { TextInputMask } from 'react-native-masked-text';
import emailValidator from 'email-validator';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import { Picker } from '@react-native-picker/picker';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import GlobalStyle from '../../components/GlobalStyle';
import { InputWarning } from '../../components/InputWarning';
import { PanelSlider } from '../../components/PanelSlider';
import useWithTouchable from '../../util/useWithTouchable';
import { GroupControl, Input } from '../../components/GlobalCSS';
import AddressForm from '../../components/AddressForm';

// Import de Imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';

const { cpf: cpfValidator } = require('cpf-cnpj-validator');
const { cnpj: cnpjValidator } = require('cpf-cnpj-validator');

export function ClientRegister() {
    // Variáveis
    let hasErrors = false;                                  //Checar se tem erros nos campos digitados
    const [filter, setFilter] = useState(false);

    let nomeRef, nicknameRef, phoneRef, cpfRef, emailRef, genderRef, birthdayRef,
        addressRef, numberRef, complementRef, cityRef, stateRef, districtRef, cepRef,
        neighborhoodRef, latitudeRef, longitudeRef, passwordRef, confirmpasswordRef;

    // Valores
    const name = useWithTouchable(nomeRef);                         //Nome
    const nickname = useWithTouchable(nicknameRef)                  //Apelido
    const phoneNumber = useWithTouchable(phoneRef)                  //Telefone
    const CPF = useWithTouchable(cpfRef);                           //CPF ou CNPJ
    const email = useWithTouchable(emailRef);                       //Email
    const gender = useWithTouchable(genderRef);                     //Gênero
    const birthday = useWithTouchable(birthdayRef);                 //Data de nascimento
    const password = useWithTouchable(passwordRef);                 //Senha
    const confirmPassword = useWithTouchable(confirmpasswordRef);   //Confirmar senha
    const [seePassword, setSeePassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    // Variáveis de endereço
    const address = useWithTouchable(addressRef);               //Endereço (rua)
    const number = useWithTouchable(numberRef);                 //Endereço (número)
    const complement = useWithTouchable(complementRef);         //Endereço (complemento)
    const city = useWithTouchable(cityRef);                     //Endereço (cidade)
    const state = useWithTouchable(stateRef);                   //Endereço (estado)
    const neighborhood = useWithTouchable(neighborhoodRef);     //Endereço (distrito)
    const cep = useWithTouchable(cepRef);                       //Endereço (CEP)
    const latitude = useWithTouchable(latitudeRef);             //Endereço (latitude)
    const longitude = useWithTouchable(longitudeRef);           //Endereço (longitude)

    // Referências
    const nicknameInput = useRef(null);
    const phoneNumberInput = useRef(null);
    const CPFInput = useRef(null);
    const emailInput = useRef(null);
    const passwordInput = useRef(null);
    const confirmPasswordInput = useRef(null);


    const checkError = (flag: boolean) => {
        if (flag) { hasErrors = true; }
        return flag;
    }

    // Variáveis ao carregar a página
    useEffect(() => {
        setSeePassword(true);
        setSeeConfirmPassword(true);
        setFilter(false);
    }, []);

    // Construção da tela
    return (
        <GlobalStyle>
            <ContainerTop>
                <Container pb
                    style={{
                        flexDirection: 'column',
                        alignItems: 'flex-start',
                        justifyContent: 'center',
                        width: '100%',
                    }}
                >
                    <View style={{ flexDirection: 'row', alignItems: 'center', width: '100%' }}>
                        <TouchableOpacity
                            onPress={() => console.log('voltar')}
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
                                height: 100,
                                marginTop: '27%',
                                marginRight: '25%',
                                marginLeft: 'auto',
                                // borderWidth: 1,
                                // borderColor: '#f00'
                            }}
                        />
                    </View>
                    <Text style={styles.textStyleF}>
                        RoboComp - Novo Usuário
                    </Text>
                </Container>
            </ContainerTop>
            <KeyboardAwareScrollView>
                <PanelSlider style={{ marginTop: 20 }}>
                    {/* Passo 1 */}
                    {/* Nome completo */}
                    <GroupControl>
                        <Input
                            mode='flat'
                            label='Nome completo'
                            value={name.value}
                            onChangeText={text => name.set(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            autoCapitalize='words'
                            onBlur={name.onBlur}
                            onSubmitEditing={() => nicknameInput.current.focus()}
                        />
                        <InputWarning
                            text='Campo Obrigatório'
                            valid={checkError(name.value === '')}
                            visible={true}
                        />
                    </GroupControl>
                    {/* Apelido */}
                    <GroupControl>
                        <Input
                            ref={nicknameInput}
                            mode='flat'
                            label='Apelido'
                            value={nickname.value}
                            onChangeText={text => nickname.set(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            autoCapitalize='words'
                            onBlur={nickname.onBlur}
                            onSubmitEditing={() => phoneNumberInput.current.focus()}
                        />
                        <InputWarning
                            text='Campo Obrigatório'
                            valid={checkError(nickname.value === '')}
                            visible={true}
                        />
                    </GroupControl>
                    {/* Telefone */}
                    <GroupControl>
                        <TextInputMask
                            ref={phoneRef}
                            style={styles.groupControlInput}
                            type='cel-phone'
                            options={{
                                maskType: 'BRL',
                                withDDD: true,
                                dddMask: '(99) ',
                            }}
                            customTextInput={TextInput}
                            customTextInputProps={{
                                mode: 'flat',
                                label: 'Telefone',
                                underlineColor: theme.colors.black,
                                allowFontScaling: true,
                            }}
                            value={phoneNumber.value}
                            placeholder='DDD + número'
                            onChangeText={text => phoneNumber.set(text)}
                            onBlur={phoneNumber.onBlur}
                            onSubmitEditing={() => emailInput.current.focus()}
                        />
                        <InputWarning
                            text='Campo Obrigatório'
                            valid={checkError(phoneNumber.value === '')}
                            visible={phoneNumber.blurred}
                        />
                    </GroupControl>
                    {/* Email */}
                    <GroupControl>
                        <Input
                            ref={emailInput}
                            mode='flat'
                            keyboardType='email-address'
                            label='Email'
                            autoCapitalize='none'
                            value={email.value}
                            onChangeText={() => email.set(text)}
                            underlineColor={theme.colors.black}
                            allowFontScaling
                            onBlur={phoneNumber.onBlur}
                            onSubmitEditing={() => passwordInput.current.focus()}
                        />
                        <InputWarning
                            text='Email inválido'
                            valid={checkError(email.value !== '' || !emailValidator.validate(email.value))}
                            visible={email.blurred}
                        />
                    </GroupControl>
                    {/* Senha */}
                    <GroupControl>
                        <View style={{ flexDirection: 'column' }}>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                <Input
                                    style={styles.groupControlInput2}
                                    mode='flat'
                                    label='Senha'
                                    value={password.value}
                                    secureTextEntry={seePassword}
                                    onChangeText={text => password.set(text)}
                                    underlineColor={theme.colors.black}
                                    placeholder='Mínimo de 6 dígitos'
                                    allowFontScaling
                                    onBlur={password.onBlur}
                                    ref={passwordInput}
                                    onSubmitEditing={() => confirmPasswordInput.current.focus()}
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
                                text='Campo Obrigatório'
                                valid={checkError(password.value === '')}
                                visible={password.blurred}
                            />
                        </View>
                    </GroupControl>
                    {/* Confirmar Senha */}
                    <GroupControl>
                        <View style={{ flexDirection: 'column' }}>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                <Input
                                    style={styles.groupControlInput2}
                                    mode='flat'
                                    label='Confirmar senha'
                                    value={confirmPassword.value}
                                    secureTextEntry={seeConfirmPassword}
                                    onChangeText={text => confirmPassword.set(text)}
                                    underlineColor={theme.colors.black}
                                    placeholder='Mínimo de 6 dígitos'
                                    allowFontScaling
                                    onBlur={confirmPassword.onBlur}
                                    ref={confirmPasswordInput}
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
                                text='Campo Obrigatório'
                                valid={checkError(confirmPassword.value === '')}
                                visible={confirmPassword.blurred}
                            />
                            <InputWarning
                                text='Senhas não conferem'
                                valid={checkError(confirmPassword.value !== '' && confirmPassword.value !== password.value)}
                                visible={confirmPassword.blurred}
                            />
                        </View>
                    </GroupControl>
                    {/* Passo 2 */}
                    <View
                        style={{
                            flexDirection: 'row',
                            alignItems: 'center',
                            alignSelf: 'center',
                            width: '100%',
                            justifyContent: 'center',
                            height: 'auto'
                        }}
                    >
                        {/* Cadastro de CPF ou CNPJ */}
                        {(!filter) ?
                            <GroupControl>
                                {/* Cadastro com CNPJ */}
                                <View style={{ flexDirection: 'column', width: '100%' }}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'center', alignItems: 'center' }}>
                                        <Text style={{ marginLeft: '25%' }}>CNPJ</Text>
                                        <TouchableOpacity
                                            style={styles.anuncioIcon}
                                            onPress={() => { setFilter(!filter), CPF.set(CPF.value) }}
                                        >
                                            <FontAwesome5
                                                name='toggle-off'
                                                color={theme.colors.green}
                                                size={30}
                                            />
                                        </TouchableOpacity>
                                        <Text style={{ marginRight: '25%' }}>CPF</Text>
                                    </View>

                                    <TextInputMask
                                        type={'custom'}
                                        options={{
                                            mask: '99.999.999/9999-99',
                                        }}
                                        customTextInput={TextInput}
                                        customTextInputProps={{
                                            mode: 'flat',
                                            label: 'CNPJ',
                                            underlineColor: theme.colors.black,
                                            allowFontScaling: true,
                                        }}
                                        placeholder='00.000.000/0000.00'
                                        value={CPF.value}
                                        onChangeText={text => CPF.set(text)}
                                        onBlur={() => { CPF.onBlur }}
                                        ref={cpfRef}
                                        onSubmitEditing={() => {
                                            console.log(CPF.value.replace(/[^0-9]+/g, ''));
                                        }}
                                    />
                                </View>
                                <InputWarning
                                    text='Campo Obrigatório'
                                    valid={checkError(CPF.value === '')}
                                    visible={CPF.blurred}
                                />
                                <InputWarning
                                    text='CNPJ Inválido'
                                    valid={checkError(!cnpjValidator.isValid(CPF.value) && CPF.value !== '')}
                                    visible={CPF.blurred}
                                />
                                {/* <InputWarning
                                    text='CNPJ já cadastrado'
                                    valid={checkError(v)}
                                    visible={v}
                                /> */}
                            </GroupControl>
                            :
                            <GroupControl>
                                {/* Cadastro com CPF */}
                                <View style={{ flexDirection: 'column', width: '100%' }}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'center', alignItems: 'center' }}>
                                        <Text style={{ marginLeft: '25%' }}>CNPJ</Text>
                                        <TouchableOpacity
                                            style={styles.anuncioIcon}
                                            onPress={() => { setFilter(!filter) }}
                                        >
                                            <FontAwesome5
                                                name={'toggle-on'}
                                                color={theme.colors.green}
                                                size={30}
                                            />
                                        </TouchableOpacity>
                                        <Text style={{ marginRight: '25%' }}>CPF</Text>
                                    </View>

                                    <TextInputMask
                                        type={'custom'}
                                        options={{
                                            mask: '999.999.999-99',
                                        }}
                                        customTextInput={TextInput}
                                        placeholder='000.000.000-00'
                                        customTextInputProps={{
                                            mode: 'flat',
                                            label: 'CPF',
                                            underlineColor: theme.colors.black,
                                            allowFontScaling: true,
                                        }}
                                        value={CPF.value}
                                        onChangeText={text => CPF.set(text)}
                                        onBlur={() => { CPF.onBlur }}
                                        ref={cpfRef}
                                        onSubmitEditing={() => {
                                            console.log(CPF.value.replace(/[^0-9]+/g, ''));
                                        }}
                                    />
                                    <InputWarning
                                        text='Campo Obrigatório'
                                        valid={checkError(CPF.value === '')}
                                        visible={CPF.blurred}
                                    />
                                    <InputWarning
                                        text='CPF Inválido'
                                        valid={checkError(!cpfValidator.isValid(CPF.value)) && CPF.value !== ''}
                                        visible={CPF.blurred}
                                    />
                                    {/* <InputWarning
                                        text='CPF já cadastrado'
                                        valid={checkError(v)}
                                        visible={v}
                                    /> */}
                                </View>
                                {/* Cadastro com CPF - sexo */}
                                <GroupControl>
                                    <Text>Sexo:</Text>
                                    <Picker
                                        selectedValue={gender.value}
                                        onValueChange={(itemValue, itemIndex) => gender.set(itemValue)}>
                                        <Picker.Item label='Não quero informar' value='' />
                                        <Picker.Item label='Masculino' value='masculino' />
                                        <Picker.Item label='Feminino' value='feminino' />
                                    </Picker>
                                </GroupControl>
                                {/* GroupControl Data de Nascimento */}
                                <GroupControl>
                                    <TextInputMask
                                        type='datetime'
                                        options={{
                                            format: 'DD/MM/YYYY',
                                        }}
                                        customTextInput={TextInput}
                                        placeholder='DD/MM/YYYY'
                                        customTextInputProps={{
                                            mode: 'flat',
                                            label: 'Data de nascimento',
                                            underlineColor: theme.colors.black,
                                            allowFontScaling: true,
                                        }}
                                        value={birthday.value}
                                        onChangeText={text => birthday.set(text)}
                                        onBlur={birthday.onBlur}
                                        onSubmitEditing={() => {
                                            checkError(birthday.value === '');
                                        }}
                                    />
                                    <InputWarning
                                        text='Campo obrigatório'
                                        valid={checkError(birthday.value === '')}
                                        visible={birthday.blurred}
                                    />
                                    <InputWarning
                                        text='Data em formato inválido, utilize o padrão DD/MM/YYYY'
                                        valid={checkError(!/\d\d\/\d\d\/\d\d\d\d/.test(birthday.value))}
                                        visible={birthday.blurred}
                                    />
                                </GroupControl>
                            </GroupControl>
                        }
                    </View>
                    {/* Endereço */}
                    <View style={{ flexDirection: 'row', alignItems: 'center', marginTop: 10 }}>
                        <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                        <View>
                            <Text style={{ width: 70, textAlign: 'center', color: '#A2A2A2' }}>Endereço</Text>
                        </View>
                        <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                    </View>
                    <GroupControl>
                        <AddressForm
                            address={address.value}
                            number={number.value}
                            complement={complement.value}
                            neighborhood={neighborhood.value}
                            city={city.value}
                            state={state.value}
                            cep={cep.value}
                            setAddress={address.set}
                            setNumber={number.set}
                            setComplement={complement.set}
                            setNeighborhood={neighborhood.set}
                            setCity={city.set}
                            setState={state.set}
                            setCep={cep.set}
                            setLatitude={latitude.set}
                            setLongitude={longitude.set}
                        />
                    </GroupControl>
                </PanelSlider>
            </KeyboardAwareScrollView>
        </GlobalStyle>
    );
}

const styles = StyleSheet.create({
    anuncioIcon: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        marginHorizontal: 10,
    },
    groupControlInput: {
        width: '100%',
        height: 60,
        backgroundColor: 'rgba(0,0,0,0)',
        color: theme.colors.textOnSurface,
    },
    groupControlInput2: {
        width: '90%',
        height: 60,
        backgroundColor: 'rgba(0,0,0,0)',
        color: theme.colors.textOnSurface,
    },
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