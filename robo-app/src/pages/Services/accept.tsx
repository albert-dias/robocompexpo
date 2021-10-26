// Import de pacotes
import React, { useCallback, useEffect, useState } from 'react';
import { Alert, Image, ImageBackground, StyleSheet, TouchableOpacity, View } from 'react-native';
import { Text, TextInput } from 'react-native-paper';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';
import { useFocusEffect, useNavigation } from '@react-navigation/native';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import GlobalContext from '../../context';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function AcceptServices() {
    // Variáveis
    const [services, setServices] = useState([]);
    const [text, setText] = useState('');
    const [arrayCategory, setArrayCategory] = useState([]);
    const [show, setShow] = useState([]);

    // Funções
    function currencyReal(numero) {
        var num = 0;
        if (isNaN(numero)) {
            return num = 'R$';
        }

        num = parseFloat(numero).toFixed(2)
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
                            onPress={() => console.log('navigate(InProgress)')}
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
                    alignItems: 'flex-start',
                    paddingBottom: '8%',
                }}
                >
                    <View style={{
                        flexDirection: 'row',
                        alignItems: 'center',
                        marginBottom: '1%',
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
                                borderBottomColor: '#000',
                                borderWidth: 1,
                            }}
                            onSubmitEditing={() => console.log('filterServices()')}
                        />
                        <TouchableOpacity style={{ marginLeft: 10 }} onPress={() => console.log('S: ' + JSON.stringify(services))/* filterServices() */}>
                            <FontAwesome5
                                name='search'
                                color={theme.colors.black}
                                size={20}
                            />
                        </TouchableOpacity>
                    </View>
                    <ScrollView style={styles.scrollView}>
                        <View>
                            <View /* key={serv.id} */ style={styles.anuncioCard}>
                                <View style={styles.imageInfo}>
                                    <Image style={styles.imageCard} source={logo} />
                                </View>
                                <View style={styles.anuncioInfo}>
                                    <View style={{ flexDirection: 'row' }}>
                                        <View style={{ flexDirection: 'column' }}>
                                            {/* Título do anúncio na tabela*/}
                                            <Text style={styles.adTitle}>serv.service</Text>
                                            {/* Dia e hora marcados na requisição, futuramente fazer que possa ser alterado em comum acordo entre as partes */}
                                            <Text style={{ marginRight: '12%' }}>Agendado para o dia 12/12 às 14:57</Text>

                                            {/* Preço do anúncio na tabela */}
                                            <Text style={styles.adPrice}>
                                                {currencyReal(10)}
                                            </Text>
                                        </View>

                                        {/* Aqui começaria o operador ternãrio */}
                                        <View style={{
                                            marginTop: 1,
                                            marginBottom: 'auto',
                                            marginRight: 15,
                                            marginLeft: 'auto',
                                            justifyContent: 'flex-end'
                                        }}>
                                            <TouchableOpacity onPress={() => {
                                                Alert.alert(
                                                    "Informação adicional:",
                                                    'serv.cautions',
                                                    [{
                                                        text: 'OK',
                                                        onPress: () => { },
                                                        style: 'default'
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

                                        <View style={{
                                            marginTop: 1,
                                            marginBottom: 'auto',
                                            marginRight: '6%',
                                            marginLeft: 'auto',
                                            justifyContent: 'flex-end'
                                        }}>
                                            {/* Ícone do mapa para mostrar o endereço do cliente para o técnico */}
                                            <TouchableOpacity onPress={() => {
                                                Alert.alert(
                                                    "Endereço:",
                                                    'serv.address' + ', ' + 'serv.number' +
                                                    '\n' + 'serv.district' + ' - ' + 'serv.city' + '/' + 'serv.state',
                                                    [{
                                                        text: "OK",
                                                        onPress: () => { },
                                                        style: "default"
                                                    }], { cancelable: false }
                                                );
                                            }}>
                                                <FontAwesome5
                                                    name='map-marked-alt'
                                                    color={theme.colors.black}
                                                    size={26}
                                                />
                                            </TouchableOpacity>
                                        </View>
                                    </View>
                                    <View style={{
                                        flexDirection: 'row',
                                        marginBottom: 10,
                                        marginRight: '7%',
                                        marginLeft: 'auto',
                                        marginTop: 'auto',
                                        alignItems: 'space-between',
                                        justifyContent: 'space-around',
                                    }}>
                                        <View style={{ flexDirection: 'row', alignItems: 'center', width: '80%', marginBottom: '3%' }}>
                                            <Text style={{ fontWeight: 'bold', marginRight: 5 }}>Cliente:</Text>
                                            <Text>serv.name</Text>
                                        </View>
                                        {/* Aqui começa a função com operador ternário */}
                                        <View>
                                            <TouchableOpacity
                                                style={{
                                                    position: 'relative',
                                                    alignSelf: 'flex-start',
                                                    marginRight: '3%',
                                                    alignContent: 'flex-end',
                                                    alignItems: 'flex-end',
                                                }}
                                                onPress={() => {
                                                    Alert.alert(
                                                        "RELATÓRIO",
                                                        "Deseja adicionar um relatório à este serviço?",
                                                        [{
                                                            text: 'NÃO',
                                                            onPress: () => { },
                                                        },
                                                        {
                                                            text: 'SIM',
                                                            // onPress: ()=> {History(serv)},
                                                            onPress: () => { console.log('serv.id') },
                                                        }]
                                                    );
                                                }}>
                                                <FontAwesome5
                                                    name='edit'
                                                    color={theme.colors.contrast}
                                                    size={36}
                                                />
                                            </TouchableOpacity>
                                        </View>
                                        {/* Aqui vai ter o : do operador ternário */}
                                        <View>
                                            <TouchableOpacity
                                                onPress={() => {
                                                    Alert.alert(
                                                        "AVISO",
                                                        "O serviço em andamento foi finalizado?",
                                                        [{
                                                            text: 'NÃO',
                                                            onPress: () => { },
                                                        },
                                                        {
                                                            text: 'SIM',
                                                            onPress: () => { console.log('finishingOS(serv.id, serv.status)') },
                                                        }]
                                                    );
                                                }}
                                                style={{
                                                    position: 'relative',
                                                    alignSelf: 'flex-start',
                                                    paddingLeft: 15,
                                                    alignContent: 'flex-end',
                                                    alignItems: 'flex-end',
                                                }}
                                            >
                                                <FontAwesome5
                                                    name='check-circle'
                                                    color={theme.colors.green}
                                                    size={36}
                                                />
                                            </TouchableOpacity>
                                        </View>
                                        {/* Aqui terminará a funação com operador ternário */}
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
        paddingTop: 5,
        flexGrow: 1,
        marginBottom: 'auto',

        height: '100%',
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
        borderRadius: 20,
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