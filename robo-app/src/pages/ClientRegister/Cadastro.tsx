// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { Image, StyleSheet, Text, TouchableNativeFeedback, View } from 'react-native';
import { TextInputMask } from 'react-native-masked-text';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import { FontAwesome5 } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';
import emailValidator from 'email-validator';
import { Picker } from '@react-native-picker/picker';
import { StackScreenProps } from '@react-navigation/stack';
import { ParamListBase } from '@react-navigation/routers';

// Import de páginas
import { GroupControl, Input } from '../../components/GlobalCSS';
import Container, { ContainerTop } from '../../components/Container';
import { PanelSlider } from '../../components/PanelSlider';
import GlobalContext from '../../context';
import { InputWarning } from '../../components/InputWarning';
import useWithTouchable from '../../util/useWithTouchable';
import theme from '../../global/styles/theme';
import { Button } from '../../components/Button';
import { FCWithAppStackNavigator } from '../AppStackNavigator';
import request from '../../util/request';
import transformDate from '../../util/transformDate';
import useToken from '../../util/useToken';
import { StateUser } from '../../context/auth';
import AddressForm from '../../components/AddressForm';
import GlobalStyle from '../../components/GlobalStyle';

const { cpf: cpfValidator } = require('cpf-cnpj-validator');
const { cnpj: cnpjValidator } = require('cpf-cnpj-validator');

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';
import { add } from 'react-native-reanimated';

const styles = StyleSheet.create({
    anuncioIcon: {
        flex: 1,
        marginHorizontal: 5,
        justifyContent: 'center'
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

const {
    cadastro: {
//         // Passo 1
        apelidoRef,
        cpfRef,
        nameRef,
        phoneRef,
        // Passo 2
        genderRef,
        birthdayRef,
        // Passo 3
        addressRef,
        numberRef,
        complementRef,
        cityRef,
        stateRef,
        districtRef,
        cepRef,
        latitudeRef,
        longitudeRef,
        // Passo 4
        emailRef,
        passwordRef,
        confirmPasswordRef,

        clearForm,
    }
} = GlobalContext;

// let // Passo 1
    // apelidoRef, cpfRef, nameRef, phoneRef,
    // Passo 2
    // genderRef, birthdayRef,
    // Passo 3
    // addressRef, numberRef, complementRef, cityRef, stateRef, districtRef, cepRef, latitudeRef, longitudeRef,
    // Passo 4
    // emailRef, passwordRef, confirmPasswordRef;

export function ClientRegister({ navigation }: StackScreenProps<ParamListBase>) {
    const [loading, setLoading] = useState(false);

    //Vairáveis para passar de um campo para outro
    //Passo1
    const apelidoInputRef = useRef(null);
    const telefoneInputRef = useRef(null);
    const cpfInputRef = useRef(null);
    const emailInputRef = useRef(null);
    //passo 4
    const passwordInputRef = useRef(null);
    const confirmPasswordInputRef = useRef(null);

    //Variáveis do passo 1
    const nome = useWithTouchable(nameRef);
    const apelido = useWithTouchable(apelidoRef);
    const telefone = useWithTouchable(phoneRef);
    const cpf = useWithTouchable(cpfRef);
    //Variáveis do passo 2
    const gender = useWithTouchable(genderRef);
    const birthday = useWithTouchable(birthdayRef);
    //Variáveis do passo 3
    const address = useWithTouchable(addressRef);
    const number = useWithTouchable(numberRef);
    const complement = useWithTouchable(complementRef);
    const city = useWithTouchable(cityRef);
    const state = useWithTouchable(stateRef);
    const district = useWithTouchable(districtRef);
    const cep = useWithTouchable(cepRef);
    const latitude = useWithTouchable(latitudeRef);
    const longitude = useWithTouchable(longitudeRef);
    //Variáveis do passo 4
    const email = useWithTouchable(emailRef);
    const password = useWithTouchable(passwordRef);
    const [pass, setPass] = useState(0);
    const confirmPassword = useWithTouchable(confirmPasswordRef);

    const [seePassword, setSeePassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    const [filter, setFilter] = useState(false);
    const [v, setV] = useState(false);

    let hasErrors = false;
    const checkError = (flag: boolean) => {
        if (flag) { hasErrors = true; }
        return flag;
    };

    return (
        <GlobalStyle>
            <KeyboardAwareScrollView
                contentContainerStyle={{
                    minHeight: '100%',
                }}
                style={{
                    minHeight: '90%',
                    marginTop: '5%',
                    paddingBottom: '5%',
                }}
            >
                <ContainerTop style={{ backgroundColor: 'rgba(0,0,0,0)' }}>
                    <Container
                        pb
                        // padding={30}
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
                                resizeMode="contain"
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
                            RoboComp - Novo Usuário
                        </Text>
                    </Container>
                </ContainerTop>
                <View>
                    <PanelSlider style={{ marginTop: 20 }}>
                        {/* Passo 1 */}
                        {/* GroupControl Nome Completo */}
                        <GroupControl>
                            <Input
                                mode='flat'
                                label='Nome Completo'
                                value={nome.value}
                                onChangeText={(text) => nome.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                autoCapitalize='words'
                                onBlur={nome.onBlur}
                                onSubmitEditing={() => apelidoInputRef.current.focus()}
                            />
                            <InputWarning
                                text="Campo Obrigatório"
                                valid={checkError(nome.value === '')}
                                visible={nome.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Apelido */}
                        <GroupControl>
                            <Input
                                ref={apelidoInputRef}
                                mode="flat"
                                label="Apelido"
                                value={apelido.value}
                                onChangeText={text => apelido.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                onBlur={apelido.onBlur}
                                onSubmitEditing={() =>
                                    telefoneInputRef.current._inputElement.focus()
                                }
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(apelido.value === '')}
                                visible={apelido.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Telefone */}
                        <GroupControl>
                            <TextInputMask
                                type="cel-phone"
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
                                value={telefone.value}
                                placeholder='DDD + número'
                                onChangeText={text => telefone.set(text)}
                                onBlur={telefone.onBlur}
                                ref={telefoneInputRef}
                                onSubmitEditing={() =>
                                    emailInputRef.current.focus()
                                }
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(telefone.value === '')}
                                visible={telefone.blurred}
                            />
                        </GroupControl>
                        {/* Passo 4 */}
                        {/* GroupControl Email */}
                        <GroupControl>
                            <Input
                                mode="flat"
                                autoCapitalize="none"
                                keyboardType="email-address"
                                label="Email"
                                value={email.value}
                                ref={emailInputRef}
                                onChangeText={(text) => email.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                onBlur={email.onBlur}
                                onSubmitEditing={() => passwordInputRef.current.focus()}
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(email.value === '')}
                                visible={email.blurred}
                            />
                            <InputWarning
                                text="Email inválido"
                                valid={checkError(email.value !== '' && !emailValidator.validate(email.value))}
                                visible={email.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Senha */}
                        <GroupControl>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                <Input
                                    style={{ width: '90%' }}
                                    mode="flat"
                                    label="Senha"
                                    value={password.value}
                                    secureTextEntry={seePassword}
                                    onChangeText={text => { password.set(text); setPass(text.length); }}
                                    underlineColor={theme.colors.black}
                                    placeholder='Mínimo de 6 dígitos'
                                    allowFontScaling
                                    onBlur={password.onBlur}
                                    ref={passwordInputRef}
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
                                valid={checkError(password.value === '')}
                                visible={password.blurred}
                            />
                            <InputWarning
                                text='Senha muito pequena'
                                valid={checkError(pass < 6 && password.value !== '')}
                                visible={password.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Confirmar senha */}
                        <GroupControl>
                            <View style={{ flexDirection: 'row', alignItems: 'flex-end' }}>
                                <Input
                                    style={{ width: '90%' }}
                                    mode="flat"
                                    label="Confirmar senha"
                                    value={confirmPassword.value}
                                    secureTextEntry={seeConfirmPassword}
                                    onChangeText={text => confirmPassword.set(text)}
                                    underlineColor={theme.colors.black}
                                    allowFontScaling
                                    onBlur={confirmPassword.onBlur}
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
                                text="Campo obrigatório"
                                valid={checkError(confirmPassword.value === '')}
                                visible={confirmPassword.blurred}
                            />
                            <InputWarning
                                text="Senhas não conferem"
                                valid={checkError(confirmPassword.value !== '' && confirmPassword.value !== password.value)}
                                visible={confirmPassword.blurred}
                            />
                        </GroupControl>
                        {/* Passo 2 */}
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
                                                onPress={() => { setFilter(!filter), cpf.set(cpf.value.slice(0, 14)) }}
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
                                            value={cpf.value}
                                            onChangeText={text => cpf.set(text)}
                                            onBlur={() => { cpf.onBlur; setV(false) }}
                                            ref={cpfInputRef}
                                            onSubmitEditing={() => {
                                                console.log(cpf.value.replace(/[^0-9]+/g, ''));
                                                setV(false);
                                            }}
                                        />
                                    </View>
                                    <InputWarning
                                        text="Campo Obrigatório"
                                        valid={checkError(cpf.value === '')}
                                        visible={cpf.blurred}
                                    />
                                    <InputWarning
                                        text="CNPJ Inválido"
                                        valid={checkError(!cnpjValidator.isValid(cpf.value) && cpf.value !== '')}
                                        visible={cpf.blurred}
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
                                                value={cpf.value}
                                                onChangeText={text => cpf.set(text)}
                                                onBlur={() => { cpf.onBlur; setV(false) }}
                                                ref={cpfInputRef}
                                                onSubmitEditing={() => {
                                                    console.log(cpf.value.replace(/[^0-9]+/g, ''));
                                                    setV(false);
                                                }}
                                            />
                                            <InputWarning
                                                text="Campo Obrigatório"
                                                valid={checkError(cpf.value === '')}
                                                visible={cpf.blurred}
                                            />
                                            <InputWarning
                                                text="CPF Inválido"
                                                valid={checkError(!cpfValidator.isValid(cpf.value)) && cpf.value !== ''}
                                                visible={cpf.blurred}
                                            />
                                            <InputWarning
                                                text="CPF já cadastrado"
                                                valid={checkError(v)}
                                                visible={v}
                                            />
                                        </View>
                                    </GroupControl>
                                    {/* GroupControl sexo */}
                                    <GroupControl>
                                        <Text>Sexo:</Text>
                                        <Picker
                                            selectedValue={gender.value}
                                            onValueChange={(itemValue, itemIndex) => gender.set(itemValue)}>
                                            <Picker.Item label="Não quero informar" value="" />
                                            <Picker.Item label="Masculino" value="masculino" />
                                            <Picker.Item label="Feminino" value="feminino" />
                                        </Picker>
                                    </GroupControl>
                                    {/* GroupControl Data de Nascimento */}
                                    <GroupControl>
                                        <TextInputMask
                                            type="datetime"
                                            options={{
                                                format: 'DD/MM/YYYY',
                                            }}
                                            customTextInput={Input}
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
                                            text="Campo obrigatório"
                                            valid={checkError(birthday.value === '')}
                                            visible={birthday.blurred}
                                        />
                                        <InputWarning
                                            text="Data em formato inválido, utilize o padrão DD/MM/YYYY"
                                            valid={checkError(!/\d\d\/\d\d\/\d\d\d\d/.test(birthday.value))}
                                            visible={birthday.blurred}
                                        />
                                    </GroupControl>
                                </View>
                            }
                        </View>
                        <View style={{ flexDirection: 'row', alignItems: 'center', marginTop: 10 }}>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                            <View>
                                <Text style={{ width: 70, textAlign: 'center', color: '#A2A2A2' }}>Endereço</Text>
                            </View>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                        </View>
                        {/* Passo 3 */}
                        {/* GroupControl Endereço */}
                        {/* <GroupControl>
                            <AddressForm
                                address={address.value}
                                number={number.value}
                                complement={complement.value}
                                neighborhood={district.value}
                                city={city.value}
                                state={state.value}
                                cep={cep.value}
                                setAddress={address.set}
                                setNumber={number.set}
                                setComplement={complement.set}
                                setNeighborhood={district.set}
                                setCity={city.set}
                                setState={state.set}
                                setCep={cep.set}
                                setLatitude={latitude.set}
                                setLongitude={longitude.set}
                            />
                        </GroupControl> */}
                        <GroupControl>
                                <Button
                                    onPress={()=>console.log('submit')}
                                    disabled={hasErrors}
                                    text="ENVIAR"
                                    fullWidth
                                    loading={loading}
                                    backgroundColor={theme.colors.newcolor}
                                />
                            </GroupControl>
                    </PanelSlider>
                </View>
            </KeyboardAwareScrollView>
        </GlobalStyle>
    );
}