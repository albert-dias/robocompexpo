// Import de pacotes
import React, { useEffect, useState } from 'react';
import {
    Alert, Image, ImageBackground, StyleSheet,
    TouchableOpacity, View,
} from 'react-native';
import { Text, TextInput } from 'react-native-paper';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import request from '../../util/request';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function FollowServices() {
    // Variáveis
    const [services, setServices] = useState([]);
    const [text, setText] = useState('');
    const [arrayCategory, setArrayCategory] = useState([]);
    const [show, setShow] = useState(true);
    const [show2, setShow2] = useState([]);
    const [select, setSelect] = useState('');

    // Funções

    function currencyReal(numero) {
        var num = 0;
        if (isNaN(numero)) {
            return num = 'R$';
        }

        num = parseFloat(numero).toFixed(2);
        num = num.split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    }

    // Construção da página
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
                            resizeMode='contain'
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => console.log('navigate(SeusPedidos)')}
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
                        <Text style={styles.textStyleF}>
                            RoboComp - Acompanhar Serviços
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <View style={{ backgroundColor: theme.colors.gray }}>
                <View style={{
                    flexDirection: 'column',
                    marginHorizontal: '5%',
                    marginVertical: 20,
                    width: '100%',
                    height: '100%',
                    alignItems: 'flex-start',
                }}
                >
                    <View style={{
                        flexDirection: 'row',
                        alignItems: 'center',
                    }}
                    >
                        <TextInput
                            value={text}
                            onChangeText={(ad) => setText(ad)}
                            style={{
                                height: 30,
                                marginLeft: 5,
                                width: '80%',
                                borderRadius: 8,
                                borderBottomColor: theme.colors.black,
                                borderWidth: 1,
                            }}
                            onSubmitEditing={() => console.log('filterServices()')}
                        />
                        <TouchableOpacity style={{ marginLeft: 10 }} onPress={() => console.log('filterServices()')}>
                            <FontAwesome5
                                name='search'
                                color={theme.colors.black}
                                size={20}
                            />
                        </TouchableOpacity>
                    </View>
                    <View style={{ height: '2%' }}>
                    </View>
                    <ScrollView style={styles.scrollView}>
                        {/* {(services !== null && services !== undefined) ? services.map((serv) => ( */}
                        {/* (serv.status === 'requisitado') ? */}
                        <View /* key={serv.id} */ style={styles.anuncioCard}>
                            <View style={styles.imageInfo}>
                                <Image style={styles.imageCard} source={logo} />
                            </View>
                            <View style={styles.anuncioInfo}>
                                <View style={{ flexDirection: 'row' }}>
                                    <View style={{ flexDirection: 'column' }}>
                                        {/* Título do anúncio na tabela*/}
                                        <Text style={styles.adTitle}>serv.service</Text>

                                        {/* Preço do anúncio na tabela */}
                                        <Text style={styles.adPrice}>
                                            {currencyReal(10)}
                                        </Text>
                                    </View>
                                    <View style={{
                                        marginTop: 1,
                                        marginBottom: 'auto',
                                        marginRight: '8%',
                                        marginLeft: 'auto',
                                        justifyContent: 'flex-end'
                                    }}>
                                        <TouchableOpacity onPress={() => {
                                            Alert.alert(
                                                "Informação adicional:",
                                                'serv.cautions',
                                                [{
                                                    text: "OK",
                                                    onPress: () => { },
                                                    style: "default"
                                                }], { cancelable: false }
                                            );
                                        }}>
                                            <FontAwesome5
                                                name='ellipsis-v'
                                                color={theme.colors.black}
                                                size={26}
                                            />
                                        </TouchableOpacity>
                                    </View>
                                </View>
                                <Text>serv.name</Text>
                                <View style={{
                                    flexDirection: 'row',
                                    marginBottom: 10,
                                    marginRight: '7%',
                                    marginLeft: 'auto',
                                    marginTop: 'auto'
                                }}>
                                    <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
                                        <Text style={{ maxWidth: '77%' }}>Em andamento</Text>
                                        <TouchableOpacity
                                            onPress={() => {
                                                // console.log('ID: ' + serv.id);
                                                Alert.alert(
                                                    "AVISO",
                                                    "O serviço em andamento foi finalizado?",
                                                    [{
                                                        text: 'NÃO',
                                                        onPress: () => { },
                                                    },
                                                    {
                                                        text: 'SIM',
                                                        onPress: () => { console.log('finishingClientOS(serv.id, serv.status)') },
                                                    }]
                                                );
                                            }}
                                            style={{
                                                position: 'relative',
                                                alignSelf: 'flex-start',
                                                marginLeft: '3%',
                                                alignContent: 'flex-end',
                                                alignItems: 'flex-end',
                                            }}
                                        >
                                            <FontAwesome5
                                                name='play-circle'
                                                color={theme.colors.green}
                                                size={36}
                                            />
                                        </TouchableOpacity>
                                    </View>
                                </View>
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
    container: {
        flex: 1,
        backgroundColor: theme.colors.gray,
    },
    scrollView: {
        backgroundColor: theme.colors.gray,
        marginHorizontal: 0,
        paddingVertical: 0,
        flexGrow: 1,
        marginBottom: '45%',
        height: 'auto',
    },
    anuncioInfo: {
        width: '70%',
        marginTop: 10,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: 160,
        marginRight: '10%',
        marginBottom: 10,
        borderRadius: 8,
        backgroundColor: theme.colors.whitepure,
    },
    imageInfo: {
        width: '30%',
        height: '95%',
        margin: '1%',
        borderRadius: 8,
    },
    imageCard: {
        width: '100%',
        height: '97%',
        borderRadius: 8,
    },
    deleteIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginTop: '2%',
    },
    editIcon: {
        alignSelf: 'flex-start',
        marginRight: '2%',
        marginLeft: 'auto',
        marginTop: '2%',
        marginBottom: 'auto',
    },
    adTitle: {
        fontWeight: 'bold',
        marginRight: '30%',
    },
    adPrice: { fontWeight: 'bold' },
    adCategory: {
        textAlign: 'justify',
        height: 'auto',
        width: '90%',
    },
    filter: {
        flexDirection: 'row',
        alignItems: 'center',
        paddingVertical: 5,
        paddingRight: 5,
    },
    filter2: {
        flexDirection: 'row',
        alignItems: 'center',
        marginRight: 5,
        marginLeft: 'auto',
    },
});