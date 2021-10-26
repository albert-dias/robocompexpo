// Import de pacotes
import React, { useEffect, useState } from 'react';
import {
    Alert, Image, ImageBackground, StyleSheet,
    TouchableOpacity, TouchableWithoutFeedback, View,
} from 'react-native';
import { Dialog, Portal, Text, TextInput } from 'react-native-paper';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import StarRating from 'react-native-star-rating';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import request from '../../util/request';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function FinishedOSClient() {
    // Variáveis
    const [services, setServices] = useState([]);
    const [text, setText] = useState('');
    const [visible, setVisible] = useState(false);
    const [star, setStar] = useState(0);
    const [starColor, setStarColor] = useState('');
    const [obs, setObs] = useState('');

    // Funções da página
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

    function clientRating() {
        setVisible(true);
    }
    function starColorRate(r) {
        switch (r) {
            case 0: case 0.5: case 1:
                setStarColor('red');
                break;
            case 1.5: case 2:
                setStarColor('orange');
                break;
            case 2.5: case 3:
                setStarColor('yellow');
                break;
            case 3.5: case 4:
                setStarColor('lime');
                break;
            default:
                setStarColor('green');
                break;
        }
        console.log('RATING: ' + starColor);

    }

    useEffect(() => {
        setStar('0');
        setObs('');
    }, []);

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
                            RoboComp - Serviços Finalizados
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
                }}>
                    <View style={{ flexDirection: 'row', alignItems: 'center' }}>
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
                            onSubmitEditing={() => { console.log('fetchServices()') }}
                        />
                        <TouchableOpacity style={{ marginLeft: 10 }} onPress={() => console.log('filterFinishedServices()')}>
                            <FontAwesome5
                                name='search'
                                color={theme.colors.black}
                                size={20}
                            />
                        </TouchableOpacity>
                    </View>
                    <View style={{ height: '5%' }}>
                    </View>
                    <ScrollView style={styles.scrollView}>
                        {/* {(services !== undefined) ? */}
                        {/* services.map((serv) => ( */}
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
                                        <Text>serv.name</Text>
                                    </View>
                                    {/* {(serv.status_cliente === 'finalizado' || serv.status_cliente === 'avaliado') ? */}
                                        <View style={{
                                            flexDirection: 'row',
                                            marginRight: 10,
                                            marginLeft: 'auto',
                                            marginTop: '40%',
                                            paddingRight: '2%'
                                        }}>
                                            {/* {(serv.status_cliente !== 'avaliado') ? */}
                                                <>
                                                    <Text style={{ maxWidth: '70%', paddingLeft: '6%', marginRight: '-3%' }}>AGUARDANDO AVALIAÇÃO</Text>
                                                    <FontAwesome5
                                                        name='chevron-right'
                                                        color={theme.colors.black}
                                                        size={36} />
                                                    <TouchableOpacity
                                                        onPress={() => {
                                                            Alert.alert(
                                                                "AVISO",
                                                                "Gostaria de avaliar o técnico?",
                                                                [{
                                                                    text: 'SIM',
                                                                    onPress: () => { clientRating() },
                                                                }, {
                                                                    text: 'NÃO',
                                                                    onPress: () => { },
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
                                                            name='star'
                                                            color={theme.colors.contrast5}
                                                            size={36}
                                                        />
                                                    </TouchableOpacity>
                                                </>
                                                {/* : */}
                                                {/* <TouchableWithoutFeedback
                                                    onPress={() => { }}
                                                >
                                                    <FontAwesome5
                                                        name='check'
                                                        color={theme.colors.green}
                                                        size={36}
                                                    />
                                                </TouchableWithoutFeedback> */}
                                            {/* } */}
                                            <View>
                                                <Portal>
                                                    <Dialog
                                                        visible={visible}
                                                        onDismiss={() => setVisible(false)}
                                                        style={styles.dialog}
                                                    >
                                                        <Dialog.Title style={{ marginLeft: 0 }}>AVALIAÇÃO:</Dialog.Title>
                                                        <View>
                                                            <StarRating
                                                                disabled={false}
                                                                fullStarColor={starColor}
                                                                maxStars={5}
                                                                rating={star}
                                                                selectedStar={(rating) => { setStar(rating), starColorRate(rating), console.log('VALOR: ' + rating) }}
                                                            />
                                                        </View>
                                                        <Text style={{ marginTop: 25 }}>Observações:</Text>
                                                        <TextInput
                                                            style={styles.inputAvaliation}
                                                            multiline
                                                            value={obs}
                                                            onChangeText={(text) => { setObs(text) }}
                                                        />
                                                        <TouchableOpacity
                                                            style={styles.buttonAvaliation}
                                                            onPress={() => console.log('avaliation(serv.id, star, serv.client_id, serv.company_id, obs)')}
                                                        // onPress={()=>console.log(serv.id, star, serv.client_id, serv.company_id, obs)}
                                                        >
                                                            <Text style={styles.textButtonAvaliation}>ENVIAR AVALIAÇÃO</Text>
                                                        </TouchableOpacity>
                                                    </Dialog>
                                                </Portal>
                                            </View>
                                        </View>
                                        {/* : */}
                                        {/* <View /> */}
                                    {/* } */}
                                </View>
                            </View>
                        </View>

                        {/* )) : <View />} */}
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
        maxHeight: '64%',
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
    dialog: {
        paddingHorizontal: '5%',
        paddingVertical: '5%',
        borderRadius: 20,
    },
    buttonAvaliation: {
        marginTop: '5%',
        backgroundColor: theme.colors.slider,
        borderRadius: 8,
        width: '50%',
        minHeight: 45,
        alignItems: 'center',
        justifyContent: 'center',
        paddingBottom: '5%',
        alignSelf: 'center',
    },
    textButtonAvaliation: {
        paddingTop: '5%',
        fontWeight: 'bold',
        color: theme.colors.whitepure,
    },
    inputAvaliation: {
        padding: 0,
        width: '100%',
        borderRadius: 8,
        borderBottomColor: theme.colors.black,
        borderWidth: 1,
        textAlign: 'left',
        textAlignVertical: 'top',
    }
});