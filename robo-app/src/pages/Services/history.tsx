// Import de pacotes
import React, { useState, useEffect, useRef } from 'react';
import {
    Image, ImageBackground, ScrollView,
    StyleSheet, TouchableOpacity, View
} from 'react-native';
import { Text } from 'react-native-paper';
import { FontAwesome5 } from '@expo/vector-icons';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';

// Import de páginas
import TextInput from '../../components/Input';
import { GroupControl, Input } from '../../components/GlobalCSS';
import useWithTouchable from '../../util/useWithTouchable';
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import { InputWarning } from '../../components/InputWarning';
import request from '../../util/request';
import GlobalContext from '../../context';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

let nameMachineRef = null,
    numberSerialRef = null,
    problemRef = null,
    descriptionRef = null,
    suggestionRef = null;

export function History() {

    const [service, setService] = useState([0]);
    const [loading, setLoading] = useState(false);

    const nameMachine = useWithTouchable(nameMachineRef);
    const serialNumber = useWithTouchable(numberSerialRef);
    const problem = useWithTouchable(problemRef);
    const description = useWithTouchable(descriptionRef);
    const suggestion = useWithTouchable(suggestionRef);

    const numberSerialRefer = useRef(null);
    const problemRefer = useRef(null);

    let hasErrors = false;

    const checkError = (flag: boolean) => {
        if (flag) {
            hasErrors = true;
        }
        return flag;
    };
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
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}
                    >
                        <Image
                            source={logo}
                            resizeMode='contain'
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => console.log('goBack()')}
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
                        <Text style={styles.textStyleF}>RoboComp - Informações Adicionais</Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>

            <View style={styles.scrollView}>
                <View style={styles.anuncioCard}>
                    <ScrollView persistentScrollbar>
                        <View style={{ flexDirection: 'row' }}>
                            <View style={styles.imageInfo}>
                                <Image style={styles.imageCard} source={logo} />
                            </View>
                            <View style={{ flexDirection: 'column', alignItems: 'center', width: '67%' }}>
                                <View><Text style={styles.adTitle}>service.service</Text></View>
                            </View>
                        </View>
                        <View style={{ flexDirection: 'column', width: '100%', marginHorizontal: 10 }}>
                            <View style={styles.adInfo}>
                                <Text style={{ fontWeight: 'bold', fontSize: 18, alignSelf: 'center' }}>Informações Técnicas</Text>
                            </View>
                            <View style={styles.infoText}>
                                <GroupControl style={styles.groupControl}>
                                    <Text style={{ marginLeft: '-5%', width: '35%' }}>Tipo de serviço:</Text>
                                    <View style={styles.groupControl2}>
                                        <Input
                                            style={styles.inputControl}
                                            mode='flat'
                                            value={nameMachine.value}
                                            onChangeText={(text) => nameMachine.set(text)}
                                            underlineColor={theme.colors.black}
                                            onBlur={nameMachine.onBlur}
                                            allowFontScaling
                                            returnKeyType='next'
                                            onSubmitEditing={() =>
                                                numberSerialRefer.current.focus()
                                            }
                                        />
                                        <InputWarning
                                            text="Campo obrigatório"
                                            valid={checkError(nameMachine.value === '')}
                                            visible={nameMachine.blurred}
                                        />
                                    </View>
                                </GroupControl>
                            </View>
                            <View style={styles.infoText}>
                                <GroupControl style={styles.groupControl}>
                                    <Text style={{ marginLeft: '-5%', width: '35%' }}>Número de série:</Text>
                                    <View style={styles.groupControl2}>
                                        <Input
                                            ref={numberSerialRefer}
                                            style={styles.inputControl}
                                            mode='flat'
                                            value={serialNumber.value}
                                            onChangeText={(text) => serialNumber.set(text)}
                                            underlineColor={theme.colors.black}
                                            onBlur={serialNumber.onBlur}
                                            allowFontScaling
                                            returnKeyType='next'
                                            onSubmitEditing={() =>
                                                problemRefer.current.focus()
                                            }
                                        />
                                        <InputWarning
                                            text="Campo obrigatório"
                                            valid={checkError(serialNumber.value === '')}
                                            visible={serialNumber.blurred}
                                        />
                                    </View>
                                </GroupControl>
                            </View>
                            <View style={styles.infoText}>
                                <GroupControl style={styles.groupControl}>
                                    <Text style={{ marginLeft: '-5%', width: '35%' }}>Problema encontrado:</Text>
                                    <View style={styles.groupControl2}>
                                        <Input
                                            ref={problemRefer}
                                            style={styles.inputControl}
                                            mode='flat'
                                            value={problem.value}
                                            onChangeText={(text) => problem.set(text)}
                                            underlineColor={theme.colors.black}
                                            onBlur={problem.onBlur}
                                            allowFontScaling
                                        />
                                        <InputWarning
                                            text="Campo obrigatório"
                                            valid={checkError(problem.value === '')}
                                            visible={problem.blurred}
                                        />
                                    </View>
                                </GroupControl>
                            </View>
                            <View>
                                <GroupControl style={{ width: '95%', height: '20%', marginVertical: 5, marginLeft: '-1%' }}>
                                    <Container horizontal>
                                        <Text>Descrição:</Text>
                                        <TextInput value={description} setValue={description.set} />
                                    </Container>
                                </GroupControl>
                            </View>
                            <View>
                                <GroupControl style={{ width: '95%', height: '20%', marginVertical: 5, marginLeft: '-1%' }}>
                                    <Container horizontal>
                                        <Text>Sugestões:</Text>
                                        <TextInput value={suggestion} setValue={suggestion.set} />
                                    </Container>
                                </GroupControl>
                            </View>
                            <View style={{ marginBottom: 'auto', marginTop: '5%', maxWidth: '60%', alignSelf: 'center' }}>
                                <TouchableOpacity
                                    disabled={hasErrors}
                                    style={styles.addHistory}
                                    onPress={() => { console.log('submit()') }}>
                                    {/* onPress={()=>{console.log(route.params)}}> */}
                                    <FontAwesome5
                                        name='paperclip'
                                        color={theme.colors.black}
                                        size={35}
                                        style={{ margin: 6 }}
                                    />
                                    <Text>Adicionar informações</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </ScrollView>
                </View>
            </View>
        </>
    );
}

const styles = StyleSheet.create({
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    scrollView: {
        backgroundColor: theme.colors.gray,
        marginHorizontal: 0,
        paddingTop: 5,
        flexGrow: 1,
        marginBottom: 0,
        borderTopWidth: 1,
        borderTopColor: theme.colors.black,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: '87%',
        marginHorizontal: '5%',
        marginTop: '5%',
        borderRadius: 8,
        borderWidth: 1,
        borderColor: 'black',
        padding: 0,
    },
    imageInfo: {
        width: '30%',
        height: 152,
        margin: '1%',
        borderRadius: 8,
        borderStyle: 'solid',
        borderWidth: 1,
    },
    imageCard: {
        width: '100%',
        height: '100%',
        borderRadius: 8,
    },
    adTitle: {
        fontWeight: 'bold',
        textAlign: 'center',
        fontSize: 28,
    },
    adInfo: {
        width: '100%',
        height: 'auto',
        paddingVertical: '2%',
    },

    addInfo2: {
        width: '65%',
        backgroundColor: theme.colors.whitepure,
        borderRadius: 8,
        padding: 0,
    },
    infoTitle: { flexDirection: 'row', alignItems: 'center' },
    infoText: {
        fontWeight: 'bold',
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'space-between',
        width: '100%',
    },
    addHistory: {
        flexDirection: 'row',
        // justifyContent: 'center',
        alignItems: 'center',
        borderRadius: 80,
        borderWidth: 1,
        paddingHorizontal: 15,
        backgroundColor: theme.colors.halfyellow,
    },
    groupControl: {
        flexDirection: 'row',
        paddingHorizontal: '0%',
        justifyContent: 'space-around',
        alignItems: 'baseline',
        alignContent: 'stretch',

    },
    groupControl2: {
        flexDirection: 'column',
        width: '60%',
        justifyContent: 'center',
        alignItems: 'center',
        alignSelf: 'flex-end',
        marginRight: 10,
        marginLeft: 0,
    },
    inputControl: {
        height: 35,
        backgroundColor: theme.colors.whitepure,
        borderRadius: 8,
        alignSelf: 'stretch',
        borderWidth: 1,
        borderColor: theme.colors.black,
    },
    inputControl2: {
        height: 70,
        backgroundColor: theme.colors.whitepure,
        borderRadius: 8,
        alignSelf: 'stretch',
        borderWidth: 1,
        borderColor: theme.colors.black
    },
});