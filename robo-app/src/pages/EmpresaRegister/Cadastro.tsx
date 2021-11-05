// Import de pacotes
import React, { useEffect, useState, useRef } from 'react';
import { Image, StyleSheet, Text, TouchableNativeFeedback, View } from 'react-native';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { TextInputMask } from 'react-native-masked-text';
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import { useStateLink } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';
import emailValidator from 'email-validator';
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
import Request from '../../interfaces/Request';
import GlobalStyle from '../../components/GlobalStyle';
import Select from '../../components/Select';
import useToken from '../../util/useToken';
import { StateUser } from '../../context/auth';
import AddressForm from '../../components/AddressForm';

// Import de imagens
import logo from '../../../assets/images/logo_branca_robocomp.png';

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

let //Cadastro
    //Passo 1
    cnpjRef, nameRef, apelidoRef,
    //Passo 2
    addressRef, numberRef, complementRef, districtRef, cityRef,
    stateRef, cepRef, latitudeRef, longitudeRef,
    //Passo 3
    emailRef, passwordRef, confirmPasswordRef, phoneRef,
    //Passo 4
    clearForm, categoryIdsRef,

    // Category
    categoriesRef, fetchCategories;

export function EmpresaRegister({ navigation }: StackScreenProps<ParamListBase>) {

    // const navegar = useNavigation();
    const [loading, setLoading] = useState(false);

    //Vairáveis para passar de um campo para outro
    //Passo1
    const nameInputRef = useRef(null);
    const cnpjInputRef = useRef(null);
    const telefoneRef = useRef(null);
    //Passo 3
    const emailInputRef = useRef(null);
    const passwordInputRef = useRef(null);
    const confirmPasswordInputRef = useRef(null);
    const [seePassword, setSeePassword] = useState(true);
    const [seeConfirmPassword, setSeeConfirmPassword] = useState(true);

    //Vairáveis do passo 1
    const name = useWithTouchable(nameRef);
    const cnpj = useWithTouchable(cnpjRef);
    const apelido = useWithTouchable(apelidoRef);

    //Vairáveis do passo 2
    const address = useWithTouchable(addressRef);
    const number = useWithTouchable(numberRef);
    const complement = useWithTouchable(complementRef);
    const district = useWithTouchable(districtRef);
    const city = useWithTouchable(cityRef);
    const state = useWithTouchable(stateRef);
    const cep = useWithTouchable(cepRef);
    const latitude = useWithTouchable(latitudeRef);
    const longitude = useWithTouchable(longitudeRef);

    //Variáveis do passo 3
    const email = useWithTouchable(emailRef);
    const password = useWithTouchable(passwordRef);
    const [pass, setPass] = useState(0);
    const confirmPassword = useWithTouchable(confirmPasswordRef);
    const phone = useWithTouchable(phoneRef);

    //Variáveis do passo 4
    const categoryIds = useStateLink(categoryIdsRef);
    const categories = useStateLink(categoriesRef);

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
                            RoboComp - Cadastrar Empresa
                        </Text>
                    </Container>
                </ContainerTop>
                <View>
                    <PanelSlider
                        style={{
                            marginTop: 20,
                        }}>
                        {/* Passo 1 */}
                        {/* GroupControl Nome Fantasia */}
                        <GroupControl>
                            <Input
                                mode="flat"
                                label="Nome Fantasia"
                                value={apelido.value}
                                placeholder='Nome comercial'
                                onChangeText={text => apelido.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                onBlur={apelido.onBlur}
                                onSubmitEditing={() => nameInputRef.current.focus()}
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(apelido.value === '')}
                                visible={apelido.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Razão Social */}
                        <GroupControl>
                            <Input
                                mode="flat"
                                label="Razão Social"
                                value={name.value}
                                placeholder='Nome de registro'
                                onChangeText={text => name.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                onBlur={name.onBlur}
                                ref={nameInputRef}
                                onSubmitEditing={() =>
                                    cnpjInputRef.current._inputElement.focus()
                                }
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(name.value === '')}
                                visible={name.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl CNPJ */}
                        <GroupControl>
                            <TextInputMask
                                type="cnpj"
                                customTextInput={Input}
                                customTextInputProps={{
                                    mode: 'flat',
                                    label: 'CNPJ',
                                    underlineColor: theme.colors.black,
                                    allowFontScaling: true,
                                }}
                                value={cnpj.value}
                                placeholder='00.000.000/0000-00'
                                onChangeText={text => cnpj.set(text)}
                                onBlur={() => { cnpj.onBlur; setV(false) }}
                                ref={cnpjInputRef}
                                onSubmitEditing={() => {
                                    setV(false);
                                    checkError(!cnpjValidator.isValid(cnpj.value));
                                    telefoneRef.current._inputElement.focus();
                                }}
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(cnpj.value === '')}
                                visible={cnpj.blurred}
                            />
                            <InputWarning
                                text="CNPJ inválido"
                                valid={checkError(!cnpjValidator.isValid(cnpj.value))}
                                visible={cnpj.blurred}
                            />
                            <InputWarning
                                text="CNPJ já cadastrado"
                                valid={checkError(v)}
                                visible={v}
                            />
                        </GroupControl>
                        {/* Passo 3 */}
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
                                ref={telefoneRef}
                                placeholder='DDD + número'
                                value={phone.value}
                                onChangeText={text => phone.set(text)}
                                onBlur={phone.onBlur}
                                onSubmitEditing={() => emailInputRef.current.focus()}
                            />
                            <InputWarning
                                text="Campo obrigatório"
                                valid={checkError(phone.value === '')}
                                visible={phone.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Email */}
                        <GroupControl>
                            <Input
                                mode="flat"
                                keyboardType="email-address"
                                autoCapitalize="none"
                                label="Email"
                                value={email.value}
                                onChangeText={text => email.set(text)}
                                underlineColor={theme.colors.black}
                                allowFontScaling
                                onBlur={email.onBlur}
                                ref={emailInputRef}
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
                                    placeholder='Mínimo de 6 dígitos'
                                    secureTextEntry={seePassword}
                                    onChangeText={text => { password.set(text); setPass(text.length); }}
                                    underlineColor={theme.colors.black}
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
                                text="Campo obrigatório"
                                valid={checkError(password.value === '')}
                                visible={password.blurred}
                            />
                            <InputWarning
                                text="Senha muito pequena"
                                valid={checkError(pass < 6 && password.value !== '')}
                                visible={password.blurred}
                            />
                        </GroupControl>
                        {/* GroupControl Confirmar Senha */}
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
                                visible={password.blurred}
                            />
                            <InputWarning
                                text="Senhas não conferem"
                                valid={checkError(confirmPassword.value !== password.value)}
                                visible={password.blurred}
                            />
                        </GroupControl>
                        <View style={{ flexDirection: 'row', alignItems: 'center', marginTop: 10 }}>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                            <View>
                                <Text style={{ width: 70, textAlign: 'center', color: '#A2A2A2' }}>Serviços</Text>
                            </View>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                        </View>
                        {/* Passo 4 */}
                        {/* GroupControl Selecionar Serviços */}
                        <GroupControl>
                            <Text
                                style={{
                                    textAlign: 'center',
                                }}>
                                Selecione os serviços que você executa:
                            </Text>
                        </GroupControl>
                        {/* <Text>{JSON.stringify(categories.value)}</Text> */}
                        {/*typeof categories.value !== 'undefined' && (
                            <Select
                                options={categories.value.slice(0)}
                                selected={categoryIds.value}
                                onPress={itemId => {
                                    if (categoryIds.value.includes(itemId)) {
                                        categoryIds.set(
                                            categoryIds.value.filter(
                                                currentValue => itemId !== currentValue,
                                            ),
                                        );
                                    }
                                    else { categoryIds.set(categoryIds.value.concat([itemId])); }
                                }}
                            />
                            )*/}
                        <View style={{ flexDirection: 'row', alignItems: 'center', marginTop: 10 }}>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                            <View>
                                <Text style={{ width: 70, textAlign: 'center', color: '#A2A2A2' }}>Endereço</Text>
                            </View>
                            <View style={{ flex: 1, height: 1, backgroundColor: '#A2A2A2' }} />
                        </View>
                        {/* Passo 2 */}
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
                                onPress={console.log('submit')}
                                // disabled={hasErrors}
                                text="ENVIAR"
                                fullWidth
                                loading={loading}
                                backgroundColor={theme.colors.middleColor}
                            />
                        </GroupControl>
                    </PanelSlider>
                </View>
            </KeyboardAwareScrollView>
        </GlobalStyle>
    );
}