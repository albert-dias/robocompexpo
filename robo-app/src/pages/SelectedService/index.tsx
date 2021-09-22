// Import de pacotes
import React, { useEffect, useState } from 'react';
import {
    Alert,
    Image,
    ImageBackground,
    SafeAreaView,
    StyleSheet,
    TextInput,
    TouchableOpacity,
    View
} from 'react-native';
import { Dialog, Portal, Text } from 'react-native-paper';
import DateTimePicker from '@react-native-community/datetimepicker';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';

//  Import de páginas
import { Input } from '../../components/Input';
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';
import imgTeste from '../../../assets/images/jetpack_logo.png';         //Imagem de teste

export function SelectedService() {
    // Variáveis
    var dia = new Date();
    const [date, setDate] = useState('');
    const [time, setTime] = useState('');
    const [showDate, setShowDate] = useState(false);
    const [period, setPeriod] = useState(false);
    const [hour, setHour] = useState(false);
    const [day, setDay] = useState(false);
    const [addInfo, setAddInfo] = useState('');

    // Funções da página

    // Converter em Real
    function currencyReal(numero) {
        if (isNaN(numero)) {
            return num = 'R$';
        }

        var num = 0;
        num = parseFloat(numero).toFixed(2);
        num = num.split('.');
        num[0] = `R$ ${num[0].split(/(?=(?:...)*$)/).join('.')}`;
        num = num.join(',');
        return num;
    }

    // Máscara para número de telefone
    function maskPhone(phone) {
        if (isNaN(phone)) {
            return '';
        }

        const telCrip = String(phone);
        let telCrip2;

        if (telCrip.length === 11) {
            telCrip2 = `(${telCrip.substring(0, 2)}) ${telCrip.substring(2, 7)}-${telCrip.substring(7)}`;
        } else {
            telCrip2 = `(${telCrip.substring(0, 2)}) ${telCrip.substring(2, 6)}-${telCrip.substring(6)}`;
        }
        return telCrip2;
    }

    // Setar o tempo
    const onChangeTime = (event, selectedTime) => {
        const currentTime = selectedTime || time;
        setPeriod(Platform.OS === 'ios');
        setDate(currentTime);
        console.log('CURRENTTIME: ' + currentTime);
        setPeriod(false);
    }

    // Setar a data
    const onChangeDay = (event, selectedDate) => {
        const currentDate = selectedDate || day;
        setDay(Platform.OS === 'ios');
        setDate(currentDate);
        // setshowTime(true);
        setDay(false);
    }

    // Construção da página
    return (
        <>
            {/* Cabeçalho da página */}
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignContent: 'center'
                    }}
                >
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%'
                        }}
                    >
                        <Image source={logo}
                            resizeMode={"contain"}
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }}
                        />
                        <TouchableOpacity
                            onPress={() => { console.log('VOLTAR') }}
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
                            RoboComp - Solicitar Serviço
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            {/* Meio da página */}
            <Container>
                <View style={styles.scrollView}>
                    <View style={styles.anuncioCard}>
                        <ScrollView>
                            <View style={{ flexDirection: 'row' }}>
                                <View style={styles.imageInfo}>
                                    <Image source={imgTeste} style={styles.imageCard} />
                                </View>
                                <View style={{ flexDirection: 'column', alignItems: 'center', width: '67%' }}>
                                    <View style={styles.adInfo}>
                                        {/* Título */}
                                        <Text style={styles.adTitle}>Título</Text>
                                    </View>
                                    <View style={{ flexDirection: 'row' }}>
                                        <View style={styles.adHorarios}>
                                            <TouchableOpacity onPress={() => console.log('Ver horários')}>
                                                <Text style={styles.adHorariosText}>Horários de atendimento</Text>
                                            </TouchableOpacity>
                                        </View>
                                    </View>
                                    {/* Preço do anúncio */}
                                    <Text style={styles.adPrice}>{currencyReal(parseFloat(10))}</Text>
                                </View>
                            </View>
                            <View style={{ width: '100%', height: '100%', margin: 10 }}>
                                {/* Subategoria do anúncio */}
                                <Text style={styles.adDescription3}> Subcategoria </Text>
                                {/* Descrição do anúncio na tabela */}
                                <Text style={styles.adDescription}>Descrição</Text>
                                {/* Descrição do anunciante */}
                                <View>
                                    <View style={{ flexDirection: 'row' }}>
                                        <Text style={styles.adDescription2}>Nome: </Text>
                                        <Text style={{ fontSize: 16 }}>Arthur</Text>
                                    </View>
                                    <View style={{ flexDirection: 'row' }}>
                                        <Text style={styles.adDescription2}>Email: </Text>
                                        <Text style={{ fontSize: 16 }}>email</Text>
                                    </View>
                                    <View style={{ flexDirection: 'row' }}>
                                        <Text style={styles.adDescription2}>Número:</Text>
                                        <Text style={{ fontSize: 16 }}>{maskPhone(84987654321)}</Text>
                                    </View>
                                    <View style={{ flexDirection: 'row' }}>
                                        <Text style={styles.adDescription2}>Endereço:</Text>
                                        <Text style={{ fontSize: 16 }}>Endereço</Text>
                                    </View>
                                    <Container style={{ flexDirection: 'row' }}>
                                        <Text style={styles.adDescription2}>Informações Adicionais:</Text>
                                        <TextInput multiline style={styles.addInfo} autoCapitalize='none' onChangeText={text => setAddInfo(text)} value={addInfo} />
                                    </Container>
                                    {/* Botão ára adicionar ao carrinho de compras */}
                                    <View style={{
                                        marginBottom: 0,
                                        marginTop: '5%',
                                        width: '75%',
                                        alignSelf: 'center'
                                    }}>
                                        <TouchableOpacity
                                            style={styles.addCart}
                                            onPress={() => console.log('Adicionar ao carrinho')} // onPress={()=>{addToCart(services.client_id,services.category, services.price, addinfo)}} >
                                        >
                                            <FontAwesome5
                                                name='cart-plus'
                                                color={theme.colors.black}
                                                size={35}
                                                style={{ margin: 6 }}
                                            />
                                            <Text>Adicionar ao carrinho</Text>
                                        </TouchableOpacity>
                                    </View>
                                </View>
                            </View>
                        </ScrollView>
                    </View>
                </View>
            </Container>
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
    },
    scrollView: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
        flexGrow: 1,
        marginBottom: 'auto',
    },
    anuncioInfo: {
        // backgroundColor: '#f00',
        maxWidth: '70%',
        marginTop: 10,
    },
    anuncioCard: {
        flexDirection: 'row',
        height: '85%',
        marginHorizontal: '5%',
        marginTop: '5%',
        borderRadius: 20,
        // borderWidth: 1,
        // borderColor: 'black',
        // alignItems: 'center',
        // justifyContent: 'center',
        padding: 0,
        backgroundColor: '#FFF',
    },
    imageInfo: {
        width: '30%',
        height: 152,
        // backgroundColor: '#0ff',
        // margin: '1%',
        borderRadius: 20,
        // borderStyle: 'solid',
        // borderWidth: 1,
    },
    imageCard: {
        width: '100%',
        height: '100%',
        // backgroundColor: '#0ff',
        borderRadius: 8,
        borderColor: '#000',
        borderWidth: 1
    },
    deleteIcon: {
        alignSelf: 'flex-start',
        // marginLeft: 'auto',
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
        textAlign: 'center',
        fontSize: 28,
        paddingTop: '5%',
    },
    adPrice: {
        fontWeight: 'bold',
        fontSize: 24,
        paddingTop: '5%',
    },

    adDescription: {
        textAlign: 'justify',
        fontSize: 20,
        height: 'auto',
        width: '90%',
        paddingVertical: 10,
    },

    adDescription2: {
        marginTop: 0,
        marginBottom: 0,
        alignContent: 'flex-end',
        fontWeight: 'bold',
        textAlign: 'justify',
        fontSize: 16,
        height: 'auto',
        width: '30%',
        paddingVertical: 0,
    },
    adDescription3: {
        textAlign: 'left',
        fontSize: 20,
        // height: '70%',
        height: 'auto',
        width: '90%',
        paddingVertical: 10,
        fontWeight: 'bold',
    },
    adInfo: {
        width: '100%',
        height: 'auto',
    },
    addCart: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        borderRadius: 80,
        // borderWidth: 1,
        paddingHorizontal: 15,
        backgroundColor: 'rgba(3,94,99,0.5)',
    },
    addInfo: {
        width: '60%',
        backgroundColor: '#CCC',
        borderRadius: 8,
        paddingHorizontal: 15,
        // borderWidth:1,
        // borderColor: '#000',
    },
    adHorarios: {
        marginTop: '5%',
        marginHorizontal: '1%',
        paddingVertical: '2%',
        paddingHorizontal: '5%',
        borderRadius: 80,
        justifyContent: 'flex-start',
        backgroundColor: 'rgba(3,100,110,0.5)',
        // borderWidth: 1,
    },
    adHorariosText: {
        color: '#000',
        fontWeight: 'bold',
        marginVertical: 5,
        alignSelf: 'center',
    },
    dialog: {
        padding: 5,
        borderRadius: 20,
        position: 'absolute',
        height: 'auto',
        width: '90%',
        alignItems: 'center',
        justifyContent: 'center',
        alignSelf: 'center',
        // marginVertical: '20%',
    },
});